<?php
namespace Database\Seeders;

use App\Models\EType;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

	public function run(): void {
		[$u1, $u2] = User::factory()->createMany([
			['email' => 'user-1@example.com', 'password' => 'password-1'],
			['email' => 'user-2@example.com', 'password' => 'password-2'],
			['email' => 'user-3@example.com', 'password' => 'password-3']
		]);
		Tag::factory()->createMany([
			['name' => 'tag-1', 'user_id' => $u1->id],
			['name' => 'tag-2', 'user_id' => $u1->id],
			['name' => 'tag-3', 'user_id' => $u2->id],
			['name' => 'tag-4', 'user_id' => $u2->id],
		]);
		EType::factory()->createMany([
			['name' => 'Etype 1', 'user_id' => $u1->id],
			['name' => 'Etype 2', 'user_id' => $u1->id],
			['name' => 'Etype 3', 'user_id' => $u2->id],
			['name' => 'Etype 4', 'user_id' => $u2->id],
		]);
	}
}
