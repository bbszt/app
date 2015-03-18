<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class UsersGroupsTableSeeder extends Seeder {

	public function run()
	{
        DB::table('users_groups')->truncate();

        $this->matchUser('admin@weile.com', 'Admins');
        $this->matchUser('admin1@weile.com', 'Admins');
        $this->matchUser('admin2@weile.com', 'Admins');
        $this->matchUser('admin3@weile.com', 'Admins');
        $this->matchUser('admin4@weile.com', 'Admins');
        $this->matchUser('users@weile.com', 'Users');
        $this->matchUser('groups@weile.com', 'Groups');
        $this->matchUser('permissions@weile.com', 'Permissions');
	}

    protected function matchUser($email, $group)
    {
        return Sentry::findUserByLogin($email)
            ->addGroup(Sentry::findGroupByName($group));
    }
}