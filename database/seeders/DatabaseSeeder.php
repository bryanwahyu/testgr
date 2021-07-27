<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user=new User;
        $user->email='admin@grtech.com.my';
        $user->password=bcrypt('password');
        $user->save();

        $user=new User;
        $user->email='user@grtech.com.my';
        $user->password=bcrypt('password');
        $user->save();

    }
}
