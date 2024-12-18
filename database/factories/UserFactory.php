<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // Default password
            'permission' => json_encode([
                'manage_users' => $this->faker->boolean(),
                'manage_dashboard' => $this->faker->boolean(),
                'manage_newsfeed' => $this->faker->boolean()
            ]),
            'employee_id' => $this->faker->unique()->randomNumber(5),
            'profile_image' => null,
            'remember_token' => Str::random(10)
        ];
    }

    // Custom state for admin user with all permissions
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'permission' => json_encode([
                    'manage_users' => true,
                    'manage_dashboard' => true,
                    'manage_newsfeed' => true
                ]),
            ];
        });
    }

    // Custom state for specific permissions
    public function withPermissions(array $permissions)
    {
        return $this->state(function (array $attributes) use ($permissions) {
            return [
                'permission' => json_encode($permissions),
            ];
        });
    }
}