<?php

namespace App\Http\Controllers\Auth;

use App\Mail\Mail;
use Carbon\Carbon;
use Mail as Mailer;
use App\Registration;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

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

            User::create([
                'name' => $data->name,
                'email' => $userRow->email,
                'password' => $data->password,
                'idUser' => $data->idUser,
                'email_verified_at' => Carbon::now()->timestamp
            ]);



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
            'email' => 'required|email|unique:users',
        ]);

        $data = [
            'password' => bcrypt($request->password),
            'name' => $request->name,
            'idUser' => $request['id-user']
        ];


        $found_registration = Registration::where('email',$request->email)->take(1)->get();

        $token = null;

        if(count($found_registration) == 0){
            $token = sha1("ha".$request->email.((string)date("l h:i:s"))."sh");
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
