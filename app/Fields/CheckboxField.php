<?php
namespace App\Fields;

final class CheckboxField extends StringField {

	public const array PARAMS_DEFAULT = [
		'type' => 'checkbox',
		'checked' => false
	];
}
