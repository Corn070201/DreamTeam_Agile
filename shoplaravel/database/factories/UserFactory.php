<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'admin_name' => $this->faker->name(),
            'admin_email' => $this->faker->unique()->safeEmail(),
            'admin_phone' => '0362269453',
            // 'email_verified_at' => now(),
            'admin_password' => 'a271526065baa239ee2b72a1923f4595', // password
            // 'remember_token' => Str::random(10),
        ];
    }
    // public function testDatabase(){
    //     $admin = Admin::factory()->make();

    
    // }
    // public function active(){
    //     return $this->state(function (array $attributes) {
    //         return [
    //             'active' => true,
    //         ];
    //     })->afterCreating(function (Admin $admin) {
    //         $roles = Roles::where('name','user')->get();
    //         $admin->roles()->sync($roles->pluck('id_roles')->toArray());
    //     });
    // }
    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
