@extends('layouts.master')

@section('title')
    Contact
@endsection

@section('header')
    <h1 class="uk-heading-primary uk-text-center">Contact Us</h1>
@endsection

@section('content')
<div class="uk-card uk-container">
    <div class="uk-card-body uk-padding">
        <form class="uk-form uk-form-stacked" action="/contact" method="POST" id="contact_form" uk-grid>
            @csrf
            <div class="uk-width-1-1">
                @auth
                    <label class="uk-form-label" for="name">User Name</label>
                @endauth
                @guest 
                    <label class="uk-form-label" for="name">Name</label>
                @endguest
                @if ($errors->has('name'))               
                    <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <strong>{{ $errors->first('name') }}</strong>
                    </div>
                @endif
                @auth
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon:user"></span>
                        <input class="uk-input" id="name" name="name" value="{{$user->username}}" type="text" required readonly>                
                    </div>
                @endauth
                @guest
                    <div class="uk-width-1-1">
                        <input class="uk-input" id="name" name="name" placeholder="Name" value="{{ old('name') }}" type="text" autofocus>                
                    </div>
                @endguest
            </div>
            <div class="uk-width-1-1 uk-margin-top">
                <label class="uk-form-label" for="email">Email</label>
                @if ($errors->has('email'))               
                    <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <strong>{{ $errors->first('email') }}</strong>
                    </div>
                @endif 
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon" uk-icon="icon:mail"></span>
                    @auth
                        <input class="uk-input" id="email" name="email" placeholder="Email Address" type="email" value="{{ $user->email }}" required readonly>
                    @endauth
                    @guest
                        <input class="uk-input" id="email" name="email" placeholder="Email Address" type="email" value="{{ old('email') }}"  required>
                    @endguest
                </div>
            </div>
            <fieldset class="uk-fieldset uk-padding-remove-top uk-width-1-1">
                <label class="uk-form-label" for="subject">Subject of Message</label>
                 @if ($errors->has('subject'))               
                    <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <strong>{{ $errors->first('subject') }}</strong>
                    </div>
                @endif 
                <select class="uk-select" name="subject" id="subject" required>
                    <option value='' {{ old('subject') == '' ? 'SELECTED' : '' }} disabled>Choose Message Subject</option>
                    <option value="Error Correction" {{ old('subject') == 'Error Correction' ? 'SELECTED' : '' }}>Error Correction</option>
                    <option value="Suggestion" {{ old('subject') == 'Suggestion' ? 'SELECTED' : '' }}>Winery Suggestion</option>
                    <option value="Question or Comment" {{ old('subject') == 'Question or Comment' ? 'SELECTED' : '' }}>Question or Comment</option>
                </select>
                <div class="uk-width-1-1 uk-margin-top">
                    <label class="uk-form-label" for="body">Message</label>
                     @if ($errors->has('message'))               
                        <div class="uk-alert-danger uk-margin-remove-bottom" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <strong>{{ $errors->first('message') }}</strong>
                        </div>
                    @endif 
                    <textarea class="uk-textarea uk-width-1-1 uk-form-large" id="body" value="{{ old('message') }}" placeholder="Type your message (Limited to 500 characters)" name="message" required></textarea>
                </div>
            </fieldset>
            <div class="uk-width-1-1 uk-margin-top-large uk-text-right">
                <button type="submit" class="uk-button uk-button-primary">Send</button> 
            </div>
        </form>
    </div>
</div>

@endsection