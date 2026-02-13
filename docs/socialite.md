### Socialite

##### Note: This can also be make dynamic with facebook, github etc......

`require socialite`
```
composer require laravel/socialite
```

---

`Create a OAuth in https://console.cloud.google.com`


---

`Config`
```
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_CALLBACK_REDIRECT=
```
`config/services.php`
```
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_CALLBACK_REDIRECT')
]
```
---
`routes/web.php`
```
/**
 * Google Auth Route
 */
Route::get('auth/google', [SocialiteController::class, 'googleLogin'])->name('auth.google');
```

---

`views`
```
<a href="{{ route('auth.google') }}">Login with google</a>
```

---

`Controller`
### Setup the controller with Laravel/Socialite
```
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
     * GET the user name,
     */
    public function googleAuthentication()
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
                $user = User::create([
                    'name' => $userGoogle->name,
                    'email' => $userGoogle->email,
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
```

---