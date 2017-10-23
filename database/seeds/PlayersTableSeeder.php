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
			['surname'=>'Verhelst','first_name'=>'Thomas','email'=>'tvke91@gmail.com','adres'=>'Mechelsesteenweg 156','postalcode'=>'2550','city'=>'Kontich','ip'=>'127.0.0.1','start'=>null,'end'=>null,'time'=>'1234','possible_dis'=>'0','disqualified'=>'0','safety_token'=>'','friend_token'=>null,'friend_email'=>null,],
			['surname'=>'Serrien','first_name'=>'Sam','email'=>'sam.serrien@kdg.be','adres'=>'Tramasantlei 122','postalcode'=>'2550','city'=>'Schoten','ip'=>'127.0.0.1','start'=>null,'end'=>null,'time'=>'800','possible_dis'=>'0','disqualified'=>'0','safety_token'=>'','friend_token'=>null,'friend_email'=>null,],
		]);
	}
}
