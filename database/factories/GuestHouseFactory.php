<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class GuestHouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $imagePath = public_path('images');
        $images = glob($imagePath . '/*.{jpg,png,gif}', GLOB_BRACE);
        $room_images = [];

        for($i = 0; $i < 5; $i++) {
            $room_images[$i] = $images ? str_replace($imagePath . '/', '', $this->faker->randomElement($images)) : null;
        }

        $room_images_string = implode(',', $room_images);

        return [
            //
            'owner_id' => $this->faker->numberBetween(1, 10),
            // 'room_name' => $this->faker->company(),
            'title' => $this->faker->company(),
            // 'room_details' => $this->faker->sentence(9),
            'description' => $this->faker->sentence(9),
            // 'room_price' => number_format($this->faker->randomNumber(4, true), 0, '.', ','),
            'price' => number_format($this->faker->randomNumber(4, true), 0, '.', ','),
            // 'room_location' => $this->faker->city(),
            'location' => $this->faker->city(),
            'images' => $room_images_string,
            'latitude' => $this->faker->latitude(10.250000, 10.268000),
            'longitude' => $this->faker->longitude(123.930000, 123.970000),
            'guests' => $this->faker->numberBetween(1, 10),
            'beds' => $this->faker->numberBetween(1, 5),
            'rooms' => $this->faker->numberBetween(1, 10),
            'bathrooms' => $this->faker->numberBetween(1, 5),
            'amenities' => json_encode([
                    [
                        'icon' => $this->faker->randomElement(['mdi-wifi', 'mdi-television']),
                        'title' => $this->faker->word
                    ],
                    [
                        'icon' => $this->faker->randomElement(['mdi-wifi', 'mdi-television']),
                        'title' => $this->faker->word
                    ],
                    [
                        'icon' => $this->faker->randomElement(['mdi-wifi', 'mdi-television']),
                        'title' => $this->faker->word
                    ],
            ])
            //10.252763, 123.949394 Cordova setview
        ];
    }
}
