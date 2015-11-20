<?php

use Illuminate\Database\Seeder;

class OAuthClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CodeProject\Entities\OAuthClient::truncate();
        factory(CodeProject\Entities\OAuthClient::class)->create([
                'id' => 'appid1',
		        'secret' => 'secret',
		        'name' => 'APP AngularJS',
            ]);
    }
}
