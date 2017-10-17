<?php

use Illuminate\Database\Seeder;

class PlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
		DB::table('players')->insert([
//			['surname' => 'Verhelst','first_name' => 'Thomas','email' => 'tvke91@gmail.com','adres' => 'Mechelsesteenweg 156','postalcode' => '2550','city' => 'Kontich','ip' => '127.0.0.1','start' => '2017-10-13 19:02:00','end' => '2017-10-13 19:02:00','possible_dis' => 0,'disqualified' => 0,'friend_token' => null,],
		]);
	}
}
