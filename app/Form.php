<?php
namespace App;

use App\Enum\Http\Method;
use App\View\Components\Button;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function array_map;

final readonly class Form {

	/**
	 * @param string $action
	 * @param Method $method
	 * @param Field[] $fields
	 * @param Button[] $buttons
	 * @param null|string $title
	 * @return void
	 */
	public function __construct(
		public string $action = '',
		public Method $method = Method::POST,
		public array $fields = [],
		public array $buttons = [],
		public ?string $title = null,
		public ?array $alert = null
	) {}

	public function view(): View {
		return view('include.form', [
			'action' => $this->action,
			'method' => $this->method->name,
			'fields' => $this->fields,
			'buttons' => $this->buttons,
			'title' => $this->title,
			'alert' => $this->alert
		]);
	}

	public function field(string $name): ?Field {
		foreach ($this->fields as $f)
			if ($f->name === $name)
				return $f;
		return null;
	}

	public function toArray(): array {
		return array_from_entries(
			array_map(
				fn (Field $f): array => [$f->name, $f->value],
				$this->fields
			)
		);
	}

	public function applyRequest(Request $request): void {
		$rules = [];
		foreach ($this->fields as $f) {
			$value = $request->input($f->name);
			if ($value !== null)
				$f->value = $value;
			if ($f->validate !== null)
				$rules[$f->name] = $f->validate;
		}
		$request->validate($rules);
	}
}
