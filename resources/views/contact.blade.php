@extends('layouts.master')

@section('title')
    Contact Us
@endsection

@section('header')
    <h1 class="uk-heading-primary uk-text-center">Contact Us</h1>
@endsection

@section('content')
<div class="uk-card">
    <div class="uk-card-body uk-padding">
        <form class="uk-form uk-form-stacked" action="/contact" method="POST" id="contact_form" uk-grid>
            @csrf
            <div class="uk-width-1-1">
                @if ($errors->has('name'))               
                    <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <strong>{{ $errors->first('name') }}</strong>
                    </div>
                @endif
                @auth
                    <label class="uk-form-label" for="name">Username</label>
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon:user"></span>
                        <input class="uk-input" id="name" name="name" placeholder="User Name" value="{{ old('name') != null ? old('name') : $user->username}}" type="text"  required>                
                    </div>
                @endauth
                @guest 
                    <label class="uk-form-label" for="name">Name</label>
                    <div class="uk-width-1-1">
                        <input class="uk-input" id="name" name="name" placeholder="Name" value="{{ old('name') }}" type="text" required autofocus>                
                    </div>
                @endguest
            </div>
            <div class="uk-width-1-1 uk-margin-top">
                @if ($errors->has('email'))               
                    <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <strong>{{ $errors->first('email') }}</strong>
                    </div>
                @endif 
                <label class="uk-form-label" for="email">Email</label>
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon" uk-icon="icon:mail"></span>
                    @auth
                        <input class="uk-input" id="email" name="email" placeholder="Email Address" type="email" value="{{ old('email') != null ? old('email') : $user->email }}"  required>
                    @endauth
                    @guest
                        <input class="uk-input" id="email" name="email" placeholder="Email Address" type="email" value="{{ old('email') }}"  required>
                    @endguest
                </div>
            </div>
            <div class="uk-width-1-1 uk-margin-top">
                <label class="uk-form-label" for="subject">Subject of Message</label>
                <select class="uk-select" name="subject" id="subject" required>
                    <option value='' {{ old('subject') == '' ? 'SELECTED' : '' }} disabled>Subject of Message</option>
                    <option value="mistake" {{ old('subject') == 'mistake' ? 'SELECTED' : '' }}>Error Correction</option>
                    <option value="suggestion" {{ old('subject') == 'suggestion' ? 'SELECTED' : '' }}>Winery Suggestion</option>
                    <option value="photo" {{ old('subject') == 'photo' ? 'SELECTED' : '' }}>Photography Submission</option>
                    <option value="other" {{ old('subject') == 'other' ? 'SELECTED' : '' }}>Other</option>
                </select>
            </div>
            <div class="uk-width-1-1 uk-margin-top">
                <label class="uk-form-label" for="message">Message*</label>
                <textarea class="uk-textarea uk-width-1-1 uk-form-large" id="message" value="{{ old('message') }}" required></textarea>
            </div>
            <div class="uk-width-1-1 uk-margin-top-large uk-text-right">
                <button type="submit" class="uk-button uk-button-primary">Send Message</button> 
            </div>
        </form>
    </div>
</div>

@endsection