<?php

use Illuminate\Database\Seeder;

class PeriodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
		DB::table('periods')->insert([
			['start' => '2017-08-20 00:00:00','end' => '2017-09-20 00:00:00','winner' => '1',],
			['start' => '2017-09-20 00:00:00','end' => '2017-10-20 00:00:00','winner' => '2',],
			['start' => '2017-10-20 00:00:00','end' => '2017-11-20 00:00:00','winner' => null,],
			['start' => '2017-11-20 00:00:00','end' => '2017-12-20 00:00:00','winner' => null,],
		]);
	}
}
