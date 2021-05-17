<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert(
            [
                "name" => "Tuhairwe Edwin",
                "fwpnumber" => "NONE_CP",
                "email" => "chairperson@fwpassociation.org",
                "userType" => "chairman",
                "image" => "default.jpg",
                "password" => Hash::make("password"),
                "status" => 1
            ]
        );

        DB::table("users")->insert(
            [
                "name" => "lily",
                "fwpnumber" => "NONE_TR",
                "email" => "finance.projects@fwpassociation.org",
                "userType" => "treasurer",
                "image" => "default.jpg",
                "password" => Hash::make("passpass"),
                "status" => 1

            ]
        );
    }
}
