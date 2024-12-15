<?php
namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use function App\classname;

class Button extends Component {

	public function __construct(
		public ?string $label = null,
		public string $type = 'button',
		public ?string $variant = null,
		public ?string $class = null,
		public ?string $name = null,
		public ?string $value = null,
		public ?string $href = null,
		public ?string $icon = null,
		public ?string $iconClass = null
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
			'iconClass' => $this->iconClass,
			...$parameters,
			'class' => classname('btn', ["btn-{$this->variant}" => $this->variant], $this->class, @$parameters['class'])
		]);
	}
}
