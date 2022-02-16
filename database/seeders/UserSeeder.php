<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=new User();
        $user->name="Jesús Quishpe";
        $user->email="jesusquishpe17@gmail.com";
        $user->password=Hash::make('admin');
        $user->id_rol=1;
        $user->save();
    }
}
