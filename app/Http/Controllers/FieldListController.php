<?php
namespace App\Http\Controllers;

use App\Field;
use App\FieldRepository;
use App\Form;
use Illuminate\Contracts\View\View;
use function array_map;

final class FieldListController extends Controller {

	public function __construct(
		private readonly FieldRepository $fieldRepository
	) {}

	public function __invoke(): View {
		return view('page.fields', [
			'title' => __('page.fields.title'),
			'form' => new Form(
				fields: array_map(
					fn (string $Field): Field => new $Field(
						label: $Field::getTypeName(),
						name: $Field::getTypeName(),
						value: $Field::getTypeName(),
						readonly: true
					),
					$this->fieldRepository->all()
				)
			)
		]);
	}
}
