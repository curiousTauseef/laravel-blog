<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Session;
use Socialite;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/posts';
    // Session::flash('success', 'The blog post was successfully saved!');

    public function authenticated($request, $user)
    {
        if (Auth::check()) {
            Session::flash('success', 'You have logged in!');
        }  
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Redirect the user to the Instagram authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::with('instagram')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $socialuser = Socialite::with('instagram')->user();
        $user = User::where('instagram_id', $socialuser->getId())->first();

        // dd($socialuser);
        if(!$user) {
            User::create([
                'instagram_id' => $socialuser->getId(),
                'name' => $socialuser->getName(),
                'email' => $socialuser->getId(),
            ]);
        };

        auth()->login($user);
        return redirect()->to($this->redirectTo);
    }
}
