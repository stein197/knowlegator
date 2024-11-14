<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	public function up(): void {
		Schema::create('etypes', function (Blueprint $table) {
			$table->uuid('id')->primary();
			$table->string('name');
			$table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->timestamps();
		});
	}

	public function down(): void {
		Schema::dropIfExists('etypes');
	}
};
