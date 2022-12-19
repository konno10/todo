<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class usersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
          [
            'name' => '武田信玄',
            'email' => 'test@gmail.com',
            'password' => 'password',
            'img' => 'https://picsum.photos/500/300?image=30',
            'token' => 'test@gmail.com'.Str::random(100),
          ],
          [
            'name' => '今野龍之介',
            'email' => 'ryu@gmail.com',
            'password' => 'password',
            'img' => 'https://picsum.photos/500/300?image=40',
            'token' => 'ryu@gmail.com'.Str::random(100),
          ],
          [
            'name' => '今野翔太郎',
            'email' => 'sho@gmail.com',
            'password' => 'password',
            'img' => 'https://picsum.photos/500/300?image=10',
            'token' => 'sho@gmail.com'.Str::random(100),
          ],
          [
            'name' => '今野亜良士',
            'email' => 'arashi@gmail.com',
            'password' => 'password',
            'img' => 'https://picsum.photos/500/300?image=11',
            'token' => 'arashi@gmail.com'.Str::random(100),
          ],
      ]);
      User::factory()->count(30)->create();
    }
}
