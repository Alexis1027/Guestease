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
            'room_name' => $this->faker->company(),
            'room_details' => $this->faker->sentence(9),
            'room_price' => number_format($this->faker->randomNumber(4, true), 0, '.', ','),
            'room_location' => $this->faker->city(),
            'room_image' => $room_images_string,
            'latitude' => $this->faker->latitude(10.000000, 10.300000),
            'longitude' => $this->faker->longitude(123.800000,124.000000)
            //10.252763, 123.949394 Cordova setview
        ];
    }
}
