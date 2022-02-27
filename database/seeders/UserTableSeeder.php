<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $username = env('CREDENTIALS_USERNAME');
        $email = env('CREDENTIALS_EMAIL');
        $password = env('CREDENTIALS_PASSWORD');

        try {
            $user = new User;
            $user->username = $username;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();
        } catch (Exception $e) {
        }
    }
}
