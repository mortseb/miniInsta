<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // n'importe quel utilisateur
            'user_id' => \App\Models\User::get()->random()->id,
            // n'importe quel article
            'posts_id' => \App\Models\Posts::get()->random()->id,
            // un texte aléatoire de 20 à 400 caractères
            'body' => fake()->realTextBetween($minNbChars = 20, $maxNbChars = 400),
            // une date aléatoire entre -2 mois et maintenant
            'created_at' => fake()->dateTimeBetween('-2 months', 'now'),
        ];
    }
}
