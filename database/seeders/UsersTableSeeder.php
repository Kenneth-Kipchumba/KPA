<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'                   => 1,
                'name'                 => 'Admin',
                'email'                => 'admin@admin.com',
                'password'             => bcrypt('password'),
                'remember_token'       => null,
                'approved'             => 1,
                'member_no'            => '',
                'phone'                => '',
                'id_no'                => '',
                'board_reg_no'         => '',
                'workstation'          => '',
                'postal_code'          => '',
                'address'              => '',
                'postal_address'       => '',
                'latitude'             => '',
                'longitude'            => '',
                'designation_other'    => '',
                'specialization_other' => '',
                'custom_field_1'       => '',
                'custom_field_2'       => '',
                'custom_field_3'       => '',
                'custom_field_4'       => '',
                'custom_field_5'       => '',
                'custom_field_6'       => '',
                'custom_field_7'       => '',
                'custom_field_8'       => '',
                'custom_field_9'       => '',
                'custom_field_10'      => '',
            ],
        ];

        User::insert($users);
    }
}
