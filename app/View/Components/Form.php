<?php
namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use function sizeof;

final class Form extends Component {

	private int $btnBSSize;

	/**
	 * Create a new component instance.
	 */
	public function __construct(
		private readonly string $action = '',
		private readonly string $method = 'GET',
		private readonly string $title = '',
		private readonly array $fields = [],
		private readonly array $buttons = []
	) {
		$this->btnBSSize = $buttons ? 12 / sizeof($buttons) : 0;
	}

	/**
	 * Get the view / contents that represent the component.
	 */
	public function render(): View {
		return $this->view('components.form', [
			'action' => $this->action,
			'method' => $this->method,
			'title' => $this->title,
			'fields' => $this->fields,
			'buttons' => $this->buttons,
			'btnBSSize' => $this->btnBSSize
		]);
	}
}
