<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'              => 'Vitomir',             
                'email'             => 'vittomirpetrovic@gmail.com',
                'password'          => bcrypt('vitomir'),              
                'api_token'         => bin2hex(openssl_random_pseudo_bytes(30)),
                'created_at'        => Carbon::now('Europe/Belgrade')->format('Y-m-d H:i:s'),
                'updated_at'        => Carbon::now('Europe/Belgrade')->format('Y-m-d H:i:s'),
            ]
        ];
        
        
        DB::table('users')->insert($data);
    }
}
