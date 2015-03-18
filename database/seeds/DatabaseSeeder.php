<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		$this->call('UsersTableSeeder');
		$this->call('GroupsTableSeeder');
//		$this->call('UsersGroupsTableSeeder');
//		$this->call('PermissionsTableSeeder');
//		$this->call('MembersTableSeeder');
//		$this->call('SelectEducationTableSeeder');
//		$this->call('SelectHouseTableSeeder');
//		$this->call('SelectMarriageStatusTableSeeder');
//		$this->call('SelectMonthlyIncomeTableSeeder');
//		$this->call('SelectPositionTableSeeder');
//		$this->call('SelectProfessionTableSeeder');
//		$this->call('SelectTrafficTableSeeder');
//		$this->call('SelectSexTableSeeder');
//        $this->call('CategoryTableSeeder');
//        $this->call('OrderedTreeDistrictTableSeeder');
//        $this->call('BankInfoTableSeeder');
	}

}
