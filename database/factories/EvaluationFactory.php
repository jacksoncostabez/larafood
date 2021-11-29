<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => Order::factory(),
            'client_id' => Client::factory(),
            'stars' => 5,
            'comment' => Str::random(10),
        ];
    }
}
