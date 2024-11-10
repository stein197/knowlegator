<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {

	/** @use HasFactory<\Database\Factories\UserFactory> */
	use HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 * @var array<int, string>
	 */
	protected $fillable = [
		'email',
		'password',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	public function tags(): HasMany {
		return $this->hasMany(Tag::class);
	}

	/**
	 * Find a tag by id for this user.
	 * @param string $id Tag id to find by.
	 * @return ?Tag Found tag or `null` if the user doesn't have a tag with the given id.
	 */
	public function findTagById(string $id): ?Tag {
		return $this->tags->firstWhere('id', $id);
	}

	/**
	 * Find a tag by its name.
	 * @param string $name Tag name.
	 * @return ?Tag Tag with the given name or `null` if there are no tags with the given name.
	 * ```php
	 * echo $user->findTagByName('tag-name')?->name;
	 * ```
	 */
	public function findTagByName(string $name): ?Tag {
		return $this->tags->firstWhere('name', $name);
	}

	/**
	 * Get the attributes that should be cast.
	 * @return array<string, string>
	 */
	protected function casts(): array {
		return [
			'email_verified_at' => 'datetime',
			'password' => 'hashed',
		];
	}

	/**
	 * Find a user by email.
	 * @param string $email Email to find a user by.
	 * @return ?static User with the given email or `null` if the user was not found.
	 */
	public static function findByEmail(string $email): ?static {
		return static::firstWhere('email', $email);
	}
}
