<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder {

	public function run()
	{
        DB::table('users')->truncate();
        $user = array(
            'first_name'   => 'Weile',
            'last_name'    => 'Admin',
            'email'        => 'admin@weile.com',
            'password'     => '111',
            'activated'    => 1,
            'activated_at' => Carbon::now(),
        );
        Sentry::createUser($user);
        $user = array(
            'first_name'   => 'Weile',
            'last_name'    => 'Admin',
            'email'        => 'admin1@weile.com',
            'password'     => '111',
            'activated'    => 1,
            'activated_at' => Carbon::now(),
        );
        Sentry::createUser($user);
        $user = array(
            'first_name'   => 'Weile',
            'last_name'    => 'Admin',
            'email'        => 'admin2@weile.com',
            'password'     => '111',
            'activated'    => 1,
            'activated_at' => Carbon::now(),
        );
        Sentry::createUser($user);

        $user = array(
            'first_name'   => 'Weile',
            'last_name'    => 'Admin',
            'email'        => 'admin3@weile.com',
            'password'     => '111',
            'activated'    => 1,
            'activated_at' => Carbon::now(),
        );
        Sentry::createUser($user);
        $user = array(
            'first_name'   => 'Weile',
            'last_name'    => 'Admin',
            'email'        => 'admin4@weile.com',
            'password'     => '111',
            'activated'    => 1,
            'activated_at' => Carbon::now(),
        );
        Sentry::createUser($user);

        $user = array(
            'first_name'   => 'Weile',
            'last_name'    => 'Admin',
            'email'        => 'users@weile.com',
            'password'     => '111',
            'activated'    => 1,
            'activated_at' => Carbon::now(),
        );
        Sentry::createUser($user);

        $user = array(
            'first_name'   => 'Weile',
            'last_name'    => 'Admin',
            'email'        => 'groups@weile.com',
            'password'     => '111',
            'activated'    => 1,
            'activated_at' => Carbon::now(),
        );
        Sentry::createUser($user);

        $user = array(
            'first_name'   => 'Weile',
            'last_name'    => 'Semi-Admin',
            'email'        => 'permissions@weile.com',
            'password'     => '111',
            'activated'    => 1,
            'activated_at' => Carbon::now(),
        );
        Sentry::createUser($user);

    }
}