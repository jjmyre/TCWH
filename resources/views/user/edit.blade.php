@extends('layouts.master')

@section('title')
    Edit Profile Info
@endsection

@section('header')
    <h1 class="uk-heading-primary uk-text-center">Edit Information</h1>
@endsection

@section('content')
    <div class="uk-flex uk-flex-center uk-margin-remove uk-padding-remove" uk-grid>
        <ul class="uk-subnav uk-subnav-pill uk-margin-right uk-margin-remove-left uk-padding-remove" uk-switcher="connect: .edit">
            <li class="uk-padding-remove"><a href="#">Password</a></li>
            <li class="uk-padding-remove"><a href="#">Email</a></li>
        </ul>
    </div>
	<div class="uk-switcher edit uk-padding-large uk-padding-remove-top">
	    <div class="uk-card uk-container">
	        <div class="uk-card-body uk-padding">
                <h2 class="uk-text">Change Password</h2>
	            <form class="uk-form uk-form-stacked" action='/edit/password' method="POST" uk-grid>
	                @csrf
	                <div class="uk-width-1-1">
	                    @if ($errors->has('current_password'))               
	                        <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
	                            <a class="uk-alert-close" uk-close></a>
	                            <strong>{{ $errors->first('current_password') }}</strong>
	                        </div>
	                    @endif 
	                    <label for="current_password" class="uk-form-label">Current Password</label>
	                    <div class="uk-inline uk-width-1-1">
	                    	<span class="uk-form-icon" uk-icon="icon:lock"></span>
	                        <input id="current_password" type="password" class="uk-input" value="{{ old('current_password') }}" name="current_password" placeholder="Current Password">                
	                    </div>
	                </div>
	                <div class="uk-width-1-1">
	                    @if ($errors->has('new_password'))               
	                        <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
	                            <a class="uk-alert-close" uk-close></a>
	                            <strong>{{ $errors->first('new_password') }}</strong>
	                        </div>
	                    @endif 
	                    <label for="new_password" class="uk-form-label">New Password</label>
	                    <div class="uk-inline uk-width-1-1">
	                        <span class="uk-form-icon" uk-icon="icon:lock"></span>
	                        <input id="new_password" type="password" class="uk-input" name="new_password" placeholder="New Password">                
	                    </div>
	                </div>
	                <div class="uk-width-1-1">
	                    <label for="new-password-confirm" class="uk-form-label">Confirm New Password</label>
	                    <div class="uk-inline uk-width-1-1">
	                        <span class="uk-form-icon" uk-icon="icon:lock"></span>
	                        <input id="new-password-confirm" type="password" class="uk-input" name="new_password_confirmation" placeholder="Confirm Password" required>                
	                    </div>
	                </div>
	                <div class="uk-width-1-1 uk-margin-top-large uk-text-right">
	                    <button type="submit" class="uk-button uk-button-primary">Update Password</button>
	                </div>
	            </form>
	        </div>
	    </div>

	    <div <div class="uk-card uk-container">
	        <div class="uk-card-body uk-padding">
	        	<h2 class="uk-text">Change Email</h2>
	            <form class="uk-form uk-form-stacked" action='/edit/email' method="POST" uk-grid>
	                @csrf
	                <div class="uk-width-1-1">
	                    @if ($errors->has('current_email'))               
	                        <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
	                            <a class="uk-alert-close" uk-close></a>
	                            <strong>{{ $errors->first('current_email') }}</strong>
	                        </div>
	                    @endif 
	                    <label for="current_password" class="uk-form-label">Current Email</label>
	                    <div class="uk-inline uk-width-1-1">
	                    	<span class="uk-form-icon" uk-icon="icon:mail"></span>
	                        <input id="current_email" type="email" class="uk-input" value="{{ old('current_email') }}" name="current_email" placeholder="Current Email Address">                
	                    </div>
	                </div>
	                <div class="uk-width-1-1">
	                    @if ($errors->has('new_email'))               
	                        <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
	                            <a class="uk-alert-close" uk-close></a>
	                            <strong>{{ $errors->first('new_email') }}</strong>
	                        </div>
	                    @endif 
	                    <label for="new_email" class="uk-form-label">New Email</label>
	                    <div class="uk-inline uk-width-1-1">
	                        <span class="uk-form-icon" uk-icon="icon:mail"></span>
	                        <input id="new_email" type="email" class="uk-input" value="{{ old('new_email') }}" name="new_email" placeholder="New Email Address">                
	                    </div>
	                </div>
	                <div class="uk-width-1-1">
	                    <label for="email" class="uk-form-label">Confirm New Email</label>
	                    <div class="uk-inline uk-width-1-1">
	                        <span class="uk-form-icon" uk-icon="icon:mail"></span>
	                        <input id="email-confirm" type="email" class="uk-input" name="new_email_confirmation" placeholder="Confirm New Email Address" required>                
	                    </div>
	                </div>
	                <div class="uk-width-1-1 uk-margin-top-large uk-text-right">
	                    <button type="submit" class="uk-button uk-button-primary">Update Email</button>
	                </div>
	            </form>
	        </div>
	    </div>
@endsection