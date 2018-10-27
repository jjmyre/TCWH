@extends('layouts.master')

@section('title')
    Create Account
@endsection

@section('header')
    <h1 class="uk-heading-primary uk-text-center">Create Account</h1>
@endsection

@section('content')
    <form class="uk-form uk-form-stacked uk-padding-large" action="{{ route('register') }}" method="POST" id="signup-form" uk-grid>
        {{ csrf_field() }}
        <div class="uk-width-1-1">
            <label class="uk-form-label" for="name">User Name</label>
            <div class="uk-inline uk-width-1-1">
                <span class="uk-form-icon" uk-icon="icon:user"></span>
                <input class="uk-input" id="name" name="name" placeholder="User Name" value="{{ old('name') }}" type="text"  required autofocus>                
            </div>
        </div>
        <div class="uk-width-1-1 uk-margin-top">
            <label class="uk-form-label" for="email">Email</label>
            <div class="uk-inline uk-width-1-1">
                <span class="uk-form-icon" uk-icon="icon:mail"></span>
                <input class="uk-input" id="email" name="email" placeholder="Email Address" type="email" value="{{ old('email') }}"  required>
            </div>
        </div>
        <div class="uk-width-1-1 uk-margin-top">
            <label class="uk-form-label" for="password">Password</label>
            <div class="uk-inline uk-width-1-1">
                <span class="uk-form-icon" uk-icon="icon:lock"></span>
                <input class="uk-input" id="password" name="password" placeholder="Password" type="text" required>
            </div>
        </div>
        <div class="uk-width-1-1 uk-margin-top">     
            <label class="uk-form-label" for="password_confirm">Confirm Password</label>
            <div class="uk-inline uk-width-1-1">
                <span class="uk-form-icon" uk-icon="icon:lock"></span>
                <input class="uk-input" id="password-confirm" name="password_confirm" placeholder="Password" type="text" required>
            </div>
        </div>
        <div class="uk-width-1-1 uk-margin-top">
            <button type="submit" class="uk-button uk-button-primary uk-width-1-1 uk-margin-medium-top">Signup</button>
        </div>
    </form>

@endsection