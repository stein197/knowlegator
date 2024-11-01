<?php
namespace App\Services;

use App\Enum\Theme;
use Illuminate\Session\SessionManager;
use function strtolower;

final readonly class ThemeService {

	public function __construct(
		private readonly SessionManager $sessionManager
	) {}

	public function __toString(): string {
		$theme = $this->get();
		return $theme ? strtolower($theme->name) : '';
	}

	public function dark(): bool {
		return $this->get() === Theme::Dark;
	}

	public function get(): ?Theme {
		$value = $this->sessionManager->get('theme');
		return $value ? Theme::from($value) : null;
	}

	public function set(?Theme $theme): void {
		$this->sessionManager->put('theme', $theme->name);
	}
}
