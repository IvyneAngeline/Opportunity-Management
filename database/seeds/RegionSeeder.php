<?php

use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions=['Africa','North America','South America','Europe','Asia','Australia'];

        foreach ($regions as $r){
            \Illuminate\Support\Facades\DB::table('regions')->insert(
               [
                   'region'=>$r
               ]
            );

        }
    }
}
