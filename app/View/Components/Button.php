<?php
namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use function App\classname;

class Button extends Component {

	public function __construct(
		private ?string $label = null,
		private string $type = 'button',
		private ?string $variant = null,
		private ?string $class = null,
		private ?string $name = null,
		private ?string $value = null,
		private ?string $href = null,
		private ?string $icon = null
	) {}

	public function render(array $parameters = []): View {
		return view('components.button', [
			'label' => $this->label,
			'type' => $this->type,
			'variant' => $this->variant,
			'name' => $this->name,
			'value' => $this->value,
			'href' => $this->href,
			'icon' => $this->icon,
			...$parameters,
			'class' => classname('btn', ["btn-{$this->variant}" => $this->variant], $this->class, @$parameters['class'])
		]);
	}
}
