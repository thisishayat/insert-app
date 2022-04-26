<?php

use Illuminate\Database\Seeder;

class UsersNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users_number_seeders')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $rows = [];

        $rows[] = [
            'call_receive_number' => '+390280886909',
            'email' => 'vpaservice@vpaservice.it',
            'start_end' => '1',
            'service_id'=>'43',
        ];
        $rows[] = [
            'call_receive_number' => '+390280886909',
            'email' => 'vpaservice@vpaservice.it',
            'start_end' => '2',
            'service_id'=>'44',
        ];
        $rows[] = [
            'call_receive_number' => '+395406011904',
            'email' => 'helpdesknazionale@cafcsn.it',
            'start_end' => '1',
            'service_id'=>'36',
        ];
        $rows[] = [
            'call_receive_number' => '+3904441497243',
            'email' => 'csnvicenza@cafcsn.it',
            'start_end' => '1',
            'service_id'=>'47',
        ];
        $rows[] = [
            'call_receive_number' => '+3904441497243',
            'email' => 'csnvicenza@cafcsn.it',
            'start_end' => '2',
            'service_id'=>'38',
        ];
        $rows[] = [
            'call_receive_number' => '+3904441497243',
            'email' => 'csnvicenza@cafcsn.it',
            'start_end' => '3',
            'service_id'=>'39',
        ];
        $rows[] = [
            'call_receive_number' => '+3904441497243',
            'email' => 'csnvicenza@cafcsn.it',
            'start_end' => '4',
            'service_id'=>'40',
        ];
        $rows[] = [
            'call_receive_number' => '+3904441497243',
            'email' => 'csnvicenza@cafcsn.it',
            'start_end' => '5',
            'service_id'=>'41',
        ];
        $rows[] = [
            'call_receive_number' => '+3904441497243',
            'email' => 'csnvicenza@cafcsn.it',
            'start_end' => '6',
            'service_id'=>'42',
        ];
        $rows[] = [
            'call_receive_number' => '+3904441497243',
            'email' => 'csnvicenza@cafcsn.it',
            'start_end' => '9',
            'service_id'=>'48',
        ];
        $rows[] = [
            'call_receive_number' => '+390687155140',
            'email' => 'csnroma@cafcsn.it',
            'start_end' => '1',
            'service_id'=>'49',
        ];
        $rows[] = [
            'call_receive_number' => '+390687155140',
            'email' => 'csnroma@cafcsn.it',
            'start_end' => '2',
            'service_id'=>'50',
        ];
        $rows[] = [
            'call_receive_number' => '+390490990064',
            'email' => 'csnpadova@cafcsn.it',
            'start_end' => '1',
            'service_id'=>'51',
        ];
        $rows[] = [
            'call_receive_number' => '+390490990064',
            'email' => 'csnpadova@cafcsn.it',
            'start_end' => '2',
            'service_id'=>'52',
        ];
        $rows[] = [
            'call_receive_number' => '+390621128742',
            'email' => 'info@spidservice.it',
            'start_end' => '1',
            'service_id'=>'45',
        ];
        $rows[] = [
            'call_receive_number' => '+390621128742',
            'email' => 'info@spidservice.it',
            'start_end' => '2',
            'service_id'=>'46',
        ];


        DB::table('users_number_seeders')->insert($rows);

        echo "users number seeder run successfully. \n";

    }
}
