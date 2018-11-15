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
            <form class="uk-form uk-form-stacked" action="{{ route('password.email') }}" method="POST" uk-grid>
                @csrf
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
                        <input id="email_reset" type="email" class="uk-input" name="email" value="{{ old('email') }}" required autofocus placeholder="Your Email Address">                
                    </div>
                </div>
                <div class="uk-width-1-1 uk-margin-top-large uk-text-right">
                    <button type="submit" class="uk-button uk-button-primary">Send Reset Link</button>
                </div>
            </form>
        </div>
    </div>
@endsection   