<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'name' => 'Berkay',
            'email' => 'berkay@scoutium.com',
            'password' => bcrypt('password'),
            'wallet' => 0,
            'currency' => 'TRY'
        ];
        User::create($user);
    }
}
