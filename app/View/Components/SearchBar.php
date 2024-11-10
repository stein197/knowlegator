<?php
namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchBar extends Component {

	public function __construct(
		private readonly string $action,
		private readonly string $value = '',
		private readonly string $placeholder = ''
	) {}

	public function render(): View {
		return $this->view('components.search-bar', [
			'action' => $this->action,
			'value' => $this->value,
			'placeholder' => $this->placeholder
		]);
	}
}
