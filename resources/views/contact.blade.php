@extends('layouts.master')

@section('title')
    Contact Us
@endsection

@section('header')
    Contact Us
@endsection

@section('content')
    <form class="uk-form uk-form-stacked" action="/contact" method="post" id="contact_form">
        <fieldset class="uk-fieldset">
            <div class="uk-form-row">
                <label class="uk-form-label" for="name">Name*</label>
                <input class="uk-input" type="text" id="name" required aria-required="true">
            </div>
            <div class="uk-form-row">     
                <label class="uk-form-label" for="email">Email*</label>
                <input class="uk-input" type="email" id="email" required aria-required="true">
            </div>
        </fieldset>
        <fieldset class="uk-fieldset uk-margin-top">
            <label class="uk-form-label" for="survey">Subject of Message</label>
            <select class="uk-select" aria-required="false" id="survey">
                <option>Error Correction</option>
                <option>Winery Suggestion</option>
                <option>Photography Submission</option>
            </select>
        </fieldset>
            <div class="uk-form-row">
                <label class="uk-form-label" for="message">Message*</label>
                <textarea class="uk-textarea uk-width-1-1 uk-form-large" id="message" required aria-required="true"></textarea>
            </div>
        </fieldset>


        <button type="submit" class="uk-button uk-button-primary uk-width-1-1 uk-margin-medium-top">Send</button> 
    </form>
@endsection