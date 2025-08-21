<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    // No middleware needed for this controller as all methods are public
    
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'nullable|string|max:255'
        ]);

        $subscriber = NewsletterSubscriber::firstOrCreate(
            ['email' => $validated['email']],
            $validated + ['is_active' => true]
        );

        if ($subscriber->wasRecentlyCreated) {
            UserActivity::log(
                UserActivity::ACTION_NEWSLETTER_SIGNUP,
                'Newsletter subscription: ' . $validated['email']
            );

            return back()->with('success', 'Successfully subscribed to newsletter!');
        }

        if (!$subscriber->is_active) {
            $subscriber->resubscribe();
            return back()->with('success', 'Welcome back! You\'re subscribed again.');
        }

        return back()->with('info', 'You\'re already subscribed to our newsletter!');
    }

    public function unsubscribe(Request $request, $token)
    {
        $subscriber = NewsletterSubscriber::where('token', $token)->firstOrFail();
        $subscriber->unsubscribe();

        return view('newsletter.unsubscribed', compact('subscriber'));
    }
}
