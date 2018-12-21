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

        // validate contact form inputs
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required|string|min:10|max:500',
        ]);


        // retrieve data from inputs and assign to variables
        $name = $request->input('name');
        $email = $request->input('email');
        $subject = $request->input('subject');
        $body = $request->input('message');

        // create array from the above given variable data
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

        return redirect()->back()->with('status', 'Your message was successfully sent!');
    }   

}
