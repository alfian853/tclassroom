<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use Illuminate\Support\Facades\DB;
use App\Registration;
use App\Mail\Mail;
use Session;
use Mail;
use Validator;
use Auth;
use Storage;


class StudentController extends Controller
{
	public function register() {
		return view('.register');
	}

  public function confirmRegistration(Request $request){
    $userRow = Registration::where('rg_token',$request->token)->take(1)->get();
    if(count($userRow) == 0){
      Session::flash('alert',"Invalid confirmation token!");
      Session::flash('alert-type','failed');
    }
    else{
      $userRow=$userRow[0];
      // dd($userRow['rg_email']);
      Member::create([
  			   'm_name' => $userRow['rg_name'],
        	 'email' => $userRow['rg_email'],
        	 'm_borndate' => $userRow['rg_borndate'],
        	 'm_address' => $userRow['rg_address'],
  			   'password' => $userRow['rg_password'],
  			   'm_telp' => $userRow['rg_telp']
  		]);

      Registration::where('rg_token',$request->token)->delete();
      Session::flash('alert',"Registration complete, you can login now");
      Session::flash('alert-type','success');
    }

    return redirect('home');
  }

	public function requestMailVerification(Request $request) {
		$time = strtotime("-18 year", time());
		$date = date("Y-m-d", $time);

		Validator::make($request->all(),[
			    'name' => 'required|min:4',
    			'password' => 'required|min:8|confirmed|strong_pwd',
    			'password_confirmation' => 'same:password',
    			'email' => 'required|email|unique:members|unique:company',
    			'address' => 'required|min:10',
    			'telp' => 'required|phone_number',
    			'tgllahir' => 'required|date_format:Y-m-d|before:'.$date,
	    	],
    		[
	    		'tgllahir.before' => 'your age must atleast 18 years old'
		    ]
	    )->validate($request->all());

    $linkToken = sha1("ha".$request->email.((string)date("l h:i:s"))."sh");
    Registration::create([
      'rg_email' => $request->email,
      'rg_name' => $request->name,
      'rg_token' => $linkToken,
      'rg_borndate' => $request->tgllahir,
      'rg_address' => $request->address,
      'rg_password' => bcrypt($request->password),
      'rg_telp' => $request->telp,
    ]);
    $mailObj = new Mail();
    $mailObj->setRegistMail($request->name,$linkToken,Mail::$Member);
    Mail::to($request->email)->send($mailObj);

    Session::flash('alert','Please confirm the registration through email we sent to you');
    Session::flash('alert-type','success');
    return redirect('home');

  }

    public function store(Request $request)
    {
        //Validate
        $request->validate([
            'title' => 'required|min:3',
            'description' => 'required',
        ]);

        $task = Task::create(['title' => $request->title,'description' => $request->description]);
        return redirect('/tasks/'.$task->id);
    }

		function getMemberData($id){
			$user = DB::table('members')
			->select(
				'members.*',
				DB::raw('sum(member_points.point) as total_point'),
				DB::raw('GROUP_CONCAT(skills.name) as skill_name'),
				DB::raw('GROUP_CONCAT(skills.id) as skill_id'),
				DB::raw('GROUP_CONCAT(member_points.point) as skill_point')
			)
			->where('m_id','=',$id)
			->join('member_points','member_points.member_id','=','members.m_id')
			->join('skills','skills.id','=','member_points.skill_id')
			->first();
			$user->skills_name = preg_split("/,/",$user->skill_name);
			$user->skills_point = preg_split("/,/",$user->skill_point);
			$user->skills_id = preg_split("/,/",$user->skill_id);

			return $user;
		}

    public function showProfile()
    {
      return view('members.viewProfile')->with([
				'user' => self::getMemberData(Auth::guard('member')->user()->m_id),
				'own_profile' => true,
				'canTest' => false
			]);
    }

		public function canGiveTestimoni($member){
			$job_done_at_company = DB::table('jobs_taken')
					->join('jobs', 'jobs.id', '=', 'jobs_taken.job_id')
					->where('jobs_taken.worker_email', '=', $member->email)
					->where('jobs_taken.status', '=', '4')
					->where('jobs.company_id', '=', Auth::guard('company')->user()->c_id)
					->first();
				return ($job_done_at_company != null);

		}

		public function showProfileById($id)
    {
			$canTest = false;
			$member = self::getMemberData($id);
			if(Auth::guard('company')->check()){
				$canTest = self::canGiveTestimoni($member);
			}
      return view('members.viewProfile')->with([
				'user' => $member,
				'own_profile' => false,
				'canTest' => $canTest
			]);;
    }

		public function updateProfilPict(Request $request){
			$request->validate([
					'file' => 'mimes:png,jpg,jpeg'
			]);
			if($request->file('file') != null){
				$path = Storage::putFile('public', $request->file('file'));
				$targetPath = date('Y-m-d-H-m-s').'-'.$request->file('file')->getClientOriginalName();
				$oldfile = DB::table('members')
				->select('members.m_image')
				->where('m_name','=',$request->nick)->first()->m_image;
				if($oldfile != null){
					Storage::delete('members_photo/'.$oldfile);
				}
				Storage::move($path,'members_photo/'.$targetPath);
				DB::table('members')
				->where('m_name','=',$request->nick)
				->update(['m_image' => $targetPath]);
				return response()->json([
					'status' => 'success',
					'newpath' => asset('members_photo').'/'.$targetPath
				]);
			}
		}

		public function updateName(Request $request){
			$data = json_decode($request->data_send,true);
			if($data['new_nickname'] != ""){
				DB::table('members')
				->where('m_id','=',Auth::guard('member')->user()->m_id)
				->update(['m_name' => $data['new_nickname'] ]);
				return response()->json([
					'status' => 'success',
					'message' => 'success change name'
				]);
			}
			else{
				return response()->json([
					'status' => 'failed',
					'message' => 'something wrong'
				]);
			}
		}

		public function updateQuote(Request $request){
			$data = json_decode($request->data_send,true);
			if($data['new_quote'] != ""){
				DB::table('members')
				->where('m_id','=',Auth::guard('member')->user()->m_id)
				->update(['quote' => $data['new_quote'] ]);
				return response()->json([
					'status' => 'success',
					'message' => 'success change quote'
				]);
			}
			else{
				return response()->json([
					'status' => 'failed',
					'message' => 'something wrong'
				]);
			}
		}

		public function updateTestimony(Request $request){
			$member = Member::find($request->id);
			$data = json_decode($request->data_send,true);
			if(Auth::guard('company')->check() && self::canGiveTestimoni($member)){
				$query = DB::table('company_members')->select('*')
				->where('company_id','=',Auth::guard('company')->user()->c_id)
				->where('member_id','=',$member->m_id);
				if($query->first() == null){
					DB::table('company_members')->insert([
						'company_id' => Auth::guard('company')->user()->c_id,
						'member_id' => $member->m_id,
						'content' => $data['new_testimoni']
					]);
				}
				else{
					$query->update([
						'content' => $data['new_testimoni']
					]);
				}
			}

			return response()->json([
					'status' => 'success',
					'message' => 'Thanks for your testimoni'
			]);
		}

}
