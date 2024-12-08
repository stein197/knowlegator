<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use function stripos;

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

	public function etypes(): HasMany {
		return $this->hasMany(EType::class);
	}

	/**
	 * Create a tag that automatically linked to this user.
	 * @param array $attributes Tag attributes.
	 * @return Tag Freshly created tag.
	 * ```php
	 * $t = $u->createTag(['name' => 'tag-1']);
	 * ```
	 */
	public function createTag(array $attributes): Tag {
		return new Tag(['user' => $this, ...$attributes]);
	}

	/**
	 * Create an etype that automatically linked to this user.
	 * @param array $attributes Entity type attributes.
	 * @return EType Freshly created etype.
	 * ```php
	 * $t = $u->createEtype(['name' => 'Entity type']);
	 * ```
	 */
	public function createEtype(array $attributes): EType {
		return new EType(['user' => $this, ...$attributes]);
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
	 * Find an entity type by id.
	 * @param string $id Entity type id to find by.
	 * @return ?Tag Found entity type or `null` if the user doesn't have an entity type with the given id.
	 */
	public function findEtypeById(string $id): ?EType {
		return $this->etypes->firstWhere('id', $id);
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
	 * Find tags by the given search query. The matching is case-insensetive.
	 * @param string $q Search query.
	 * @return Collection Tags matching the query.
	 * ```php
	 * $u->findTagsByQuery('tag'); // Collection
	 * ```
	 */
	public function findTagsByQuery(string $q): Collection {
		return $q ? $this->tags->filter(fn (Tag $t): bool => stripos($t->name, $q) !== false) : $this->tags;
	}

	/**
	 * Find entity types by the given search query. The matching is case-insensetive.
	 * @param string $q Search query.
	 * @return Collection Entity types matching the query.
	 * ```php
	 * $u->findEtypesByQuery('entity'); // Collection
	 * ```
	 */
	public function findEtypesByQuery(string $q): Collection {
		return $q ? $this->etypes->filter(fn (EType $etype): bool => stripos($etype->name, $q) !== false || stripos($etype->description, $q) !== false) : $this->etypes;
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
