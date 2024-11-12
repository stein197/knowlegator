<?php
namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

final class Alert extends Component {

	public function __construct(
		private readonly string $type = '',
		private readonly ?string $icon = 'exclamation-triangle-fill'
	) {}

	public function render(): View {
		return view('components.alert', [
			'type' => $this->type,
			'icon' => $this->icon
		]);
	}
}
