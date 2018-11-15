@extends('layouts.master')

@section('title')
    Password Reset
@endsection

@section('header')
    <h1 class="uk-heading-primary uk-text-center">Password Reset</h1>
@endsection

@section('content')
    <div class="uk-card">
        <div class="uk-card-body uk-padding">
            <form class="uk-form uk-form-stacked" action="{{ route('password.request') }}" method="POST" uk-grid>
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="uk-width-1-1">
                    @if ($errors->has('email'))               
                        <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif 
                    <label for="email" class="visuallyHidden">E-Mail Address</label>
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon:mail"></span>
                        <input id="email" type="email" class="uk-input" name="email" value="{{ $email ?? old('email') }}" required autofocus placeholder="Your Email Address">                
                    </div>
                </div>
                <div class="uk-width-1-1">
                    @if ($errors->has('password'))               
                        <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                    @endif 
                    <label for="password" class="visuallyHidden">Password</label>
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon:lock"></span>
                        <input id="password" type="password" class="uk-input" name="password" placeholder="Your New Password">                
                    </div>
                </div>
                <div class="uk-width-1-1">
                    <label for="email" class="visuallyHidden">Password</label>
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon:lock"></span>
                        <input id="password-confirm" type="password" class="uk-input" name="password_confirmation" placeholder="Confirm Password" required>                
                    </div>
                </div>
                <div class="uk-width-1-1 uk-margin-top-large uk-text-right">
                    <button type="submit" class="uk-button uk-button-primary">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection  
