<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Models\UserActivity;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        // Check if the user is blocked by IP
        if ($this->isIpBlocked($request)) {
            return $this->sendBlockedResponse($request);
        }

        $user = $this->create($request->all());

        Auth::login($user);

        // Log user activity
        UserActivity::log(
            UserActivity::ACTION_REGISTER,
            'User registered',
            $user
        );

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'confirmed',
                Password::min(10)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            'g-recaptcha-response' => 'required|recaptcha',
            'terms' => ['accepted'],
        ], [
            'terms.accepted' => 'You must accept the terms and conditions.',
            'g-recaptcha-response.required' => 'Please complete the reCAPTCHA verification.',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => User::ROLE_USER,
            'is_active' => true,
        ]);
    }

    protected function redirectPath()
    {
        return route('home');
    }

    protected function isIpBlocked(Request $request)
    {
        // Implement your IP blocking logic here
        // Example: return \App\Models\IpBlock::isBlocked($request->ip());
        return false;
    }

    protected function sendBlockedResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->except('password', 'password_confirmation'))
            ->withErrors([
                'email' => 'Your IP address has been blocked due to suspicious activity.',
            ]);
    }
}