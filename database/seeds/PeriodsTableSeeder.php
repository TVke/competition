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
			['start' => '2017-10-20 00:00:00','end' => '2017-11-20 00:00:00','winner' => null,],
			['start' => '2017-11-20 00:00:00','end' => '2017-12-20 00:00:00','winner' => null,],
			['start' => '2018-01-20 00:00:00','end' => '2018-02-20 00:00:00','winner' => null,],
			['start' => '2018-02-20 00:00:00','end' => '2018-03-20 00:00:00','winner' => null,],
		]);
	}
}
