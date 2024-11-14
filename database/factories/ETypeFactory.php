<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ETypeFactory extends Factory {

	public function definition(): array {
		return [
			'name' => fake()->text(20)
		];
	}
}
