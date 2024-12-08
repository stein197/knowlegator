<?php
namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component {

	public function __construct(
		private ?string $label = null,
		private string $type = 'button',
		private string $variant = 'primary',
		private ?string $class = null,
		private ?string $name = null,
		private ?string $value = null,
		private ?string $url = null,
		private ?string $icon = null
	) {}

	public function render(): View {
		return view('components.button', [
			'label' => $this->label,
			'type' => $this->type,
			'variant' => $this->variant,
			'class' => $this->class,
			'name' => $this->name,
			'value' => $this->value,
			'url' => $this->url,
			'icon' => $this->icon
		]);
	}
}
