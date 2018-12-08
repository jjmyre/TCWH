<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\User;
use Mail;

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
            'message' => 'required|string|min:10|max:500',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $subject = $request->input('subject');
        $body = $request->input('message');

        $data = array(
            'name' => $name,
            'body' => $body,
            'subject' => $subject,
            'email' => $email
        );

        // Mail out message with data array
        Mail::send('emails.contact', $data, function($message) use ($email, $name, $subject){
            $message->from($email, $name);
            $message->to('admin@tcwinehub.com', 'admin');
            $message->subject('Contact Form: '.$subject);
        });

        return back()->with('status', 'Your message was successfully sent!');

    }   

}
