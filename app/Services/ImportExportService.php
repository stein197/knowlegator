<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

// TODO
final class ImportExportService {

	private readonly User $user;

	public function __construct(Request $request) {
		$this->user = $request->user();
	}

	public function import(string $data): void {}

	public function export(): string {}
}
