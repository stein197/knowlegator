<?php
namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use function sizeof;

final class Form extends Component {

	public int $btnBSSize;

	/**
	 * Create a new component instance.
	 */
	public function __construct(
		public string $action = '',
		public string $method = 'GET',
		public string $title = '',
		public array $fields = [],
		public array $buttons = []
	) {
		$this->btnBSSize = $buttons ? 12 / sizeof($buttons) : 0;
	}

	/**
	 * Get the view / contents that represent the component.
	 */
	public function render(): View {
		return view('components.form');
	}
}
