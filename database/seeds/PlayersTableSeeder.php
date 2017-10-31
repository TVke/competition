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
			['surname'=>'Verhelst','first_name'=>'Thomas','email'=>'tv@mail.com','adres'=>'straatstraat 123','postalcode'=>'1234','city'=>'Kontich','ip'=>'127.0.0.1','start'=>'1509445191.3570','end'=>'1509445234.4769','time'=>'418','possible_dis'=>'0','disqualified'=>'0','safety_token'=>'$2y$10$CpuoA3LFy8KVQilqZPQg/OFbotGrBfRDdMEk4hefKGiJta0vsnehi','friend_token'=>null,'friend_email'=>null,],
			['surname'=>'Serrien','first_name'=>'Sam','email'=>'sam.se@mail.be','adres'=>'Tramasantlei 122','postalcode'=>'1234','city'=>'Schoten','ip'=>'127.0.0.1','start'=>'1509445737.0314','end'=>'1509445781.3445','time'=>'429','possible_dis'=>'0','disqualified'=>'0','safety_token'=>'','friend_token'=>null,'friend_email'=>null,],
		]);
	}
}
