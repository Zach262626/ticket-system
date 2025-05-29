<?php

namespace Database\Factories\Ticket;

use \App\Models\Ticket\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Ticket>
 */
class TicketFactory extends Factory
{
    protected $model = Ticket::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'description' => $this->faker->sentence(),
            'status_id' => 1,
            'level_id' => 1,
            'type_id' => 1,
            'accepted_by' => User::where('name', '=', 'tempuser')->get()->first()->id,
        ];
    }
}
