<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SocialiteController extends Controller
{
    /**
     * Redirect to google login with the users google account to choose
     * 
     * @return RedirectResponse
     */
    public function googleLogin(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Authenticate the login google account from the user
     * 
     * GET the user name, google id
     */
    public function googleAuthentication(): RedirectResponse
    {
        try {
            $userGoogle = Socialite::driver('google')->user();
            // dd($userGoogle);

            // check if the user is already register with the google account id
            $user = User::where('google_id', $userGoogle->id)
                ->orWhere('email', $userGoogle->email)
                ->first();

            // if the user is not registered with google id then create
            if (! $user) {
                // insert the user data if  not login with the google sign in
                $user = User::updateOrCreate(
                    ['email' => $userGoogle->email],
                    [
                    'name' => $userGoogle->name,
                    'google_id' => $userGoogle->id,
                    'password' => null,
                ]);
            }

            // log in and regenerate session
            Auth::login($user);
            request()->session()->regenerate();
 
            return redirect()->intended('dashboard');
        } catch (InvalidStateException $e) {
            // OAUTH Session expired
            return redirect('/login')->with('error', 'Session expired. Please try again.');
        } catch (\Exception $e) {

            // server failed
            return redirect('/login')
                ->with('error', 'Google Login failed. Please try later.')
                ->setStatusCode(500);
        }
    }
}
