<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->jobTitle,  // Menghasilkan nama pekerjaan yang acak
            'description' => $this->faker->paragraph,  // Menghasilkan deskripsi pekerjaan
            'requirement' => $this->faker->paragraph,  // Menghasilkan persyaratan pekerjaan
            'is_active' => $this->faker->boolean,  // Status aktif atau tidak
            'photo_path' => $this->faker->imageUrl(640, 480, 'business', true),  // URL gambar p
        ];
    }
}
