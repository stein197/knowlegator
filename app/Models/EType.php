<?php
namespace App\Models;

use App\Fields\StringField;
use App\Fields\TextareaField;
use App\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Entity type.
 * @package App\Models
 */
class EType extends Model {

	use HasFactory;
	use HasUuids;

	protected $table = 'etypes';
	protected $fillable = [
		'name',
		'description',
		'user_id'
	];

	public static function getPublicAttributes(): array {
		return [
			'name' => StringField::class,
			'description' => TextareaField::class
		];
	}
}
