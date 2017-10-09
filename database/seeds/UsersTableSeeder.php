<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('users')->insert([
	    	['name'=>'Thomas','email'=>'tvke91@gmail.com','password'=>bcrypt('thomas'),'sendWinner'=>1,],
	    ]);
    }
}
