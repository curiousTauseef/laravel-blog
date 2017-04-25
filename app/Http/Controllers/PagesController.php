<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests;
use Mail;
use Session;

class PagesController extends Controller {

    public function getIndex() {
        $posts = Post::orderBy('created_at', 'desc')->limit(4)->get();
        return view('pages/welcome')->withPosts($posts);
    }

    public function getAbout() {

        $first = "Jason";
        $last  = "Lai";

        // $full = $first . " " . $last;

        $fullname = "{$first} {$last}";
        $email = 'jason@cyber-duck.co.uk';
        $data = [];

        $data['email'] = $email;
        $data['fullname'] = $fullname;

        return view('pages/about')->withData($data);
    }

    public function getContact() {
        return view('pages/contact');
    }

    public function postContact(Request $request) {
        $this->validate($request, [
                'email' => 'required|email',
                'subject' => 'required|min:3',
                'message' => 'required|min:10',
            ]);

        // dd($request);
        //message key renamed bodyMessage as message is a reserved method
        $data = [
                'email' => $request->email,
                'subject' => $request->subject, 
                'bodyMessage' => $request->message
            ];

        Mail::send('emails/contact', $data, function($message) use ($data) {
            $message->from($data['email']);
            $message->to('jase_lai@hotmail.com');
            $message->subject($data['subject']);
        });

        Session::flash('success', 'Your email was sent!');

        return redirect('/');
    }

}