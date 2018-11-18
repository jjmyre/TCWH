<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class ContactController extends Controller
{
    public function show() {
    	
    	$user = Auth::user();

    	return view('contact')->with([
            'user' => $user,
        ]);
    }

    public function send(Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $name = $request->input('name');
        $userEmail = $request->input('email');
        $subject = $request->input('subject');
        $body = $request->input('body');

        $data = array(
            'name' => $name,
            'body' => $body
        );

        Mail::send('contact', $data, function($message){
            $message->subject($subject);
            $message->from($userEmail, $name);
            $message->to('admin@tcwinehub.com');
        });

        return Redirect::route('/')->with('status', 'Your message was successfully sent!');

    }   



    public function clear() {

    }

}
