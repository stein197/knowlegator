<?php
namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use function preg_match;

// TODO: user() should accept User instance
class Tag extends Model {

	use HasFactory;
	use HasUuids;

	private const string NAME_REGEX = '/^[[:alnum:]_-]+$/';

	protected $fillable = [
		'name'
	];

	public function user(): BelongsTo {
		return $this->belongsTo(User::class);
	}

	protected function name(): Attribute {
		return new Attribute(
			set: fn (string $value): string => preg_match(static::NAME_REGEX, $value) ? $value : throw new Exception("Name '{$this->name}' contains invalid characters. The name should complain the given regex: " . static::NAME_REGEX)
		);
	}
}
