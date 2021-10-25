<?php

namespace Database\Factories;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name,
            "display_name" => $this->faker->name,
            "description" => $this->faker->name,
        ];
    }
}
