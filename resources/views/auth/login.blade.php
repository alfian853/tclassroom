@extends('layouts.master')

@section('title', 'Login')

@section('add-script')
<link rel="stylesheet" type="text/css" href="{{asset('login_page/css/icon-font.min.css')}} ">
<link rel="stylesheet" type="text/css" href="{{asset('login_page/css/animate.css')}} ">
<link rel="stylesheet" type="text/css" href="{{asset('login_page/css/animsition.min.css')}} ">
<link rel="stylesheet" type="text/css" href="{{asset('login_page/css/util.css')}} ">
<link rel="stylesheet" type="text/css" href="{{asset('login_page/css/main.css')}} ">
@endsection

@section('content')

<div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-t-30 p-b-50">
                        <span class="login100-form-title p-b-41">
                            Tclassroom Login
                        </span>
                    <form class="login100-form validate-form p-b-33 p-t-5" method="POST" action="{{url('login')}}">
                        @csrf
                        @if (\Session::has('message'))
                        <div class="alert alert-danger text-center" role="alert">
                            <h6 style="font-size: 12px">{!! \Session::get('message') !!}</h6>
                        </div>
                        @endif
                        @if (\Session::has('success'))
                        <div class="alert alert-success text-center" role="alert" >
                            <h6 style="font-size: 12px">{!! \Session::get('success') !!}</h6>
                        </div>
                        @endif
                        <div class="wrap-input100 validate-input" data-validate = "Valid email is required">
                            <input id="email" class="input100" type="email" name="email" placeholder="Email" value="{{old('email')}}" required>
                            <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Password is required">
                            <input class="input100" type="password" name="password" placeholder="Password" required>
                            <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                        </div>
    
                        <div class="container-login100-form-btn m-t-32">
                            <button class="login100-form-btn">
                                Login
                            </button>
                        </div>
    
                    </form>
                </div>
            </div>
        </div>
    
@endsection