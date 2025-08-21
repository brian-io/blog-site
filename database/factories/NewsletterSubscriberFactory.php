<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NewsletterSubscriber>
 */
class NewsletterSubscriberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subscribed = fake()->boolean(90); // 90% chance to be subscribed
        return [
            'email' => fake()->email(),
            'name' => fake()->name(),
            'token' => Str::uuid(),
            'is_active' => true,
            'subscribed_at' => $subscribed ? fake()->dateTimeBetween('-1 year', 'now') : null,
            'unsubscribed_at' => $subscribed ? null : fake()->dateTimeBetween('-1 year', 'now'),

        ];
    }
}
