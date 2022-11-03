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
        $user->name = 'yamori kou';
        $user->email = 'liu.zify5521@gmail.com';
        $user->phone = '09768510897';
        $user->address = 'Yangon';
        $user->role = 'admin';
        $user->password = Hash::make('kkc552001');
        $user->save();
    }
}
