<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::create([
        //     'name' => 'igris'
        // ]);

        $user = new User();
        $user->name = 'yamori';
        $user->email = 'admin@gmail.com';
        $user->phone = '0987654321';
        $user->address = 'Aung Pan';
        $user->role = 'admin';
        $user->gender = 'male';
        $user->password = Hash::make('admin2022');
        $user->save();
    }
}
