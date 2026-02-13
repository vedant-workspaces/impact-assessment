<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class BackfillUsersNgoId extends Migration
{
	public function up(): void
	{
		// For each NGO, set the corresponding user's ngo_id to the NGO id
		$ngos = DB::table('ngos')->select('id', 'user_id')->get();

		foreach ($ngos as $ngo) {
			DB::table('users')
				->where('id', $ngo->user_id)
				->update(['ngo_id' => $ngo->id]);
		}
	}

	public function down(): void
	{
		// Revert: set all users' ngo_id to 0
		DB::table('users')->update(['ngo_id' => 0]);
	}
}

