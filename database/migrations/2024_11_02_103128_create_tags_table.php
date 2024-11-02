<?php
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	public function up(): void {
		Schema::create('tags', function (Blueprint $table) {
			$table->uuid('id')->primary();
			$table->string('name');
			$table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->unique(['user_id', 'name']);
			$table->timestamps();
		});
	}

	public function down(): void {
		Schema::dropIfExists('tags');
	}
};
