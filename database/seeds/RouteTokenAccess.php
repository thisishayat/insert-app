<?php

use Illuminate\Database\Seeder;

class RouteTokenAccess extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('api_tokens')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $rows = [];
        $rows[] = ['id' => '1','client' => 'web', 'token'=>'5361516a0a3e3d864cfc848affdb9246'];
        DB::table('api_tokens')->insert($rows);

    }
}
