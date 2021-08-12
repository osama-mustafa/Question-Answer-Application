<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence($nbWords = 6, $variableNbWords = true);
        $slug  = Str::slug($title);
        return [
            'title'   => $title,
            'body'    => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true),
            'user_id' => $this->faker->randomDigitNotNull(),
            'slug'    => $slug
        ];
    }
}
