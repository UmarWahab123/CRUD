<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class contactFormController extends Controller
{
    public function contact()
    {
        return view('contact-us');
    }
    //funtion for sending the email
    public function sendEmail(Request $request)
    {
        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'msg' => $request->msg,
        ];
        Mail::to('umarwahab672@gmail.com')->send(new ContactMail($details));
        return back()->with('message_sent', 'your message has been sent successfully!');

    }
}
