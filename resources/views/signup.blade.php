@extends('layouts.master')

@section('title')
    Create Account
@endsection

@section('header')
    <h1 class="uk-heading-primary uk-text-center">Create Account</h1>
@endsection

@section('content')
<div class="uk-card">
    <div class="uk-card-body uk-padding">
        <form class="uk-form uk-form-stacked" action="/signup" method="POST" id="signup-form" uk-grid>
            @csrf
            <div class="uk-width-1-1">
                @if ($errors->has('username'))               
                    <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <strong>{{ $errors->first('username') }}</strong>
                    </div>
                @endif 
                <label class="visuallyHidden" for="username">User Name</label>
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon" uk-icon="icon:user"></span>
                    <input class="uk-input" id="username" name="username" placeholder="User Name" value="{{ old('username') }}" type="text"  required autofocus>                
                </div>
            </div>
            <div class="uk-width-1-1 uk-margin-top">
                @if ($errors->has('email'))               
                    <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <strong>{{ $errors->first('email') }}</strong>
                    </div>
                @endif 
                <label class="visuallyHidden" for="email">Email</label>
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon" uk-icon="icon:mail"></span>
                    <input class="uk-input" id="email" name="email" placeholder="Email Address" type="email" value="{{ old('email') }}"  required>
                </div>
            </div>
            <div class="uk-width-1-1 uk-margin-top">
                @if ($errors->has('password'))               
                    <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <strong>{{ $errors->first('password') }}</strong>
                    </div>
                @endif 
                <label class="visuallyHidden" for="password">Password</label>
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon" uk-icon="icon:lock"></span>
                    <input class="uk-input" id="password" name="password" placeholder="Password" type="password" required>
                </div>
            </div>
            <div class="uk-width-1-1 uk-margin-top">
                @if ($errors->has('password_confirmation'))               
                    <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </div>
                @endif     
                <label class="visuallyHidden" for="password_confirm">Confirm Password</label>
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon" uk-icon="icon:lock"></span>
                    <input class="uk-input" id="password-confirm" name="password_confirmation" placeholder="Confirm Password" type="password" required>
                </div>
            </div>
            <div class="uk-width-1-1 uk-margin-top-large uk-text-right">
                <button type="submit" class="uk-button uk-button-primary">Sign Me Up!</button>
            </div>
        </form>
    </div>
</div>

@endsection