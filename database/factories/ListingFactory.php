<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $listing_type = $this->faker->randomElement(['Room', 'Guest house', 'Multiple room']);

        $imagePath = public_path('images/uploads');
        $images = glob($imagePath . '/*.{jpg,png,gif}', GLOB_BRACE);
        $room_images = [];

        if($listing_type == 'Guest house') {
            for($i = 0; $i < 5; $i++) {
                $room_images[$i] = $images ? str_replace($imagePath . '/', '', $this->faker->randomElement($images)) : null;
            }
        }
        else {
            for($i = 0; $i < 1; $i++) {
                $room_images[$i] = $images ? str_replace($imagePath . '/', '', $this->faker->randomElement($images)) : null;
            }
        }

        return [
            //
            'owner_id' => $this->faker->numberBetween(1, 10),
            'title' => $this->faker->company(),
            'description' => $this->faker->sentence(20),
            'price' => $this->faker->numberBetween(100, 3000),
            'location' => $this->faker->city(),
            'latitude' => $this->faker->latitude(10.250000, 10.268000),
            'longitude' => $this->faker->longitude(123.930000, 123.970000),
            'guests' => $this->faker->numberBetween(1, 9),
            'beds' => $this->faker->numberBetween(1, 5),
            'rooms' => $this->faker->numberBetween(1, 9),
            'bathrooms' => $this->faker->numberBetween(1, 5),
            'status' => 'Available',
            'type' => $listing_type,
            'images' => json_encode($room_images),
            'monthly_discount' => $this->faker->numberBetween(5, 20),
            'rules' =>json_encode([
                $this->faker->sentence(10),
                $this->faker->sentence(10),
                $this->faker->sentence(10),
                $this->faker->sentence(10),
            ]),
            'amenities' => json_encode([
                    [
                        'icon' => $this->faker->randomElement(
                            [
                                'mdi-wifi',
                                'mdi-television', 
                                'mdi-grill-outline', 
                                'mdi-countertop-outline', 
                                'mdi-fridge-outline',
                                'mdi-dishwasher',
                                'mdi-pool'
                            ]
                        ),
                        'title' => $this->faker->word
                    ],
                    [
                        'icon' => $this->faker->randomElement(
                            [
                                'mdi-wifi',
                                'mdi-television', 
                                'mdi-grill-outline', 
                                'mdi-countertop-outline', 
                                'mdi-fridge-outline',
                                'mdi-dishwasher',
                                'mdi-pool'
                            ]
                        ),
                        'title' => $this->faker->word
                    ],
                    [
                        'icon' => $this->faker->randomElement(
                            [
                                'mdi-wifi',
                                'mdi-television', 
                                'mdi-grill-outline', 
                                'mdi-countertop-outline', 
                                'mdi-fridge-outline',
                                'mdi-dishwasher',
                                'mdi-pool'
                            ]
                        ),
                        'title' => $this->faker->word
                    ],
                    [
                        'icon' => $this->faker->randomElement(
                            [
                                'mdi-wifi',
                                'mdi-television', 
                                'mdi-grill-outline', 
                                'mdi-countertop-outline', 
                                'mdi-fridge-outline',
                                'mdi-dishwasher',
                                'mdi-pool'
                            ]
                        ),
                        'title' => $this->faker->word
                    ],
            ])
            //10.252763, 123.949394 Cordova setview
        ];
    }
}
