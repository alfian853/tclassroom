<?php

namespace App\Http\Controllers\Auth;

use App\Mail\Mail;
use Mail as Mailer;
use App\Registration;
use App\Student;
use App\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Redirect;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    public function getRegister()
    {
        return view('register');
    }

    public function confirmRegistration(Request $request)
    {

        $userRow = Registration::where('token',$request->token)->take(1)->get();
        if(count($userRow) == 0){
            Session::flash('alert',"Invalid confirmation token!");
            Session::flash('alert-type','failed');
        }
        else{
            $userRow=$userRow[0];
            $data = json_decode($userRow->data);

            switch ($data->user_type){
                case 'teacher':
                    Teacher::create([
                        'name' => $data->name,
                        'email' => $userRow->email,
                        'password' => $data->password,
                        'nip' => $data->nip
                    ]);
                    break;
                case 'student':
                    Student::create([
                        'name' => $data->name,
                        'email' => $userRow->email,
                        'password' => $data->password,
                        'nrp' => $data->nrp
                    ]);
                    break;
            }



            Registration::where('token',$request->token)->delete();
            Session::flash('alert',"Registration complete, you can login now");
            Session::flash('alert-type','success');
        }

        return redirect('home');
    }

    public function requestRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4',
            'password' => 'required|min:8|confirmed',
            'email' => 'required|email|unique:teachers|unique:students',
        ]);

        $data = [
            'password' => bcrypt($request->password),
            'name' => $request->name,
            'user_type' => $request->user_type,
        ];

        switch ($request->user_type){
            case 'student':
                $request->validate(['nrp' => 'required|unique:students']);
                $data['nrp'] = $request->nrp;
                break;
            case 'teacher':
                $request->validate(['nip' => 'required|unique:teachers']);
                $data['nip'] = $request->nip;
                break;
        }


        // Check user name and email
        $found_teacher = Teacher::where('email', $request->email)->take(1)->get();
        $found_student = Student::where('email', $request->email)->take(1)->get();

        if (count($found_student) != 0 || count($found_teacher) != 0) {
            return Redirect::back()->withErrors([
                'email' => 'email had already been used!',
            ]);
        }

        $found_registration = Registration::where('email',$request->email)->take(1)->get();

        $token = null;

        if(count($found_registration) == 0){
            $token = sha1("ha".$request->email.((string)date("l h:i:s"))."sh");
//            dd($request->email);
            Registration::create([
                'email' => $request->email,
                'token' => $token,
                'data' => json_encode($data)
            ]);
        }
        else{
            $token = $found_registration[0]->token;
        }


        $mailObj = new Mail();
        $mailObj->setData(['name' => $request->name,
                    'token' => $token]);
        $mailObj->setView('mails.register');
        Mailer::to($request->email)->send($mailObj);

        Session::flash('alert','Please confirm the registration through email we sent to you');
        Session::flash('alert-type','success');
        return redirect('home');
    }
}
