@extends('layouts.master')

@section('title')
    Create Account
@endsection

@section('header')
    <h1 class="uk-heading-primary uk-text-center">Create Account</h1>
@endsection

@section('content')
    <form class="uk-form uk-form-stacked" action="/signup" method="post" id="signup-form">
        <fieldset class="uk-fieldset">
            <div class="uk-form-row">
                <label class="uk-form-label" for="name">User Name</label>
                <input class="uk-input" type="text" id="name" required>
            </div>
            <div class="uk-form-row">
                <label class="uk-form-label" for="email">Email</label>
                <input class="uk-input" type="email" id="email" required>
            </div>
            <div class="uk-form-row">
                <label class="uk-form-label" for="password">Password</label>
                <input class="uk-input" type="text" id="password" required>
            </div>
            <div class="uk-form-row">     
                <label class="uk-form-label" for="password-confirm">Confirm Password</label>
                <input class="uk-input" type="text" id="password-confirm" required>
            </div>
        </fieldset>
        <button type="submit" class="uk-button uk-button-primary uk-width-1-1 uk-margin-medium-top">Signup</button>
    </form>
@endsection