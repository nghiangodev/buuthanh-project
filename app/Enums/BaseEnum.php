<?php

namespace App\Enums;

use Illuminate\Support\Traits\Macroable;
use ReflectionClass;

abstract class BaseEnum
{
	use Macroable {
		// Because this class also defines a '__callStatic' method, a new name has to be given to the trait's '__callStatic' method.
		__callStatic as macroCallStatic;
	}

	/**
	 * The key of one of the enum members.
	 *
	 * @var mixed
	 */
	public $key;

	/**
	 * The value of one of the enum members.
	 *
	 * @var mixed
	 */
	public $value;

	/**
	 * The description of one of the enum members.
	 *
	 * @var mixed
	 */
	public $description;

	/**
	 * Constants cache.
	 *
	 * @var array
	 */
	protected static $constCacheArray = [];

	/**
	 * Construct an Enum instance.
	 *
	 * @param mixed $enumValue
	 *
	 * @throws \ReflectionException
	 * @throws InvalidEnumMemberException
	 */
	public function __construct($enumValue)
	{
		$this->value       = $enumValue;
		$this->key         = static::getKey($enumValue);
		$this->description = static::getDescription($enumValue);
	}

	/**
	 * Attempt to instantiate an enum by calling the enum key as a static method.
	 *
	 * This function defers to the macroable __callStatic function if a macro is found using the static method called.
	 *
	 * @param string $method
	 * @param mixed $parameters
	 *
	 * @throws InvalidEnumMemberException
	 * @throws \ReflectionException
	 * @return mixed
	 */
	public static function __callStatic($method, $parameters)
	{
		if (static::hasMacro($method)) {
			return static::macroCallStatic($method, $parameters);
		}

		if (static::hasKey($method)) {
			$enumValue = static::getValue($method);

			return new static($enumValue);
		}

		throw new \BadMethodCallException("Cannot create an enum instance for $method. The enum value $method does not exist.");
	}

	/**
	 * @return string
	 */
	public function __toString(): string
	{
		return (string) $this->value;
	}

	/**
	 * Return a new Enum instance,.
	 *
	 * @param mixed $enumValue
	 *
	 * @throws InvalidEnumMemberException
	 * @throws \ReflectionException
	 * @return static
	 */
	public static function getInstance($enumValue): self
	{
		if ($enumValue instanceof static) {
			return $enumValue;
		}

		return new static($enumValue);
	}

	/**
	 * Return instances of all the contained values.
	 *
	 * @throws \ReflectionException
	 * @return static[]
	 */
	public static function getInstances(): array
	{
		return array_map(
			function ($constantValue) {
				return new static($constantValue);
			},
			static::getConstants()
		);
	}

	/**
	 * Get all of the constants defined on the class.
	 *
	 * @throws \ReflectionException
	 * @return array
	 */
	protected static function getConstants(): array
	{
		$calledClass = get_called_class();

		if (! array_key_exists($calledClass, static::$constCacheArray)) {
			$reflect                               = new ReflectionClass($calledClass);
			static::$constCacheArray[$calledClass] = $reflect->getConstants();
		}

		return static::$constCacheArray[$calledClass];
	}

	/**
	 * Get all of the enum keys.
	 *
	 * @throws \ReflectionException
	 * @return array
	 */
	public static function getKeys(): array
	{
		return array_keys(static::getConstants());
	}

	/**
	 * Get all of the enum values.
	 *
	 * @throws \ReflectionException
	 * @return array
	 */
	public static function getValues(): array
	{
		return array_values(static::getConstants());
	}

	/**
	 * Get the key for a single enum value.
	 *
	 * @param mixed $value
	 *
	 * @throws \ReflectionException
	 * @return string
	 */
	public static function getKey($value): string
	{
		return array_search($value, static::getConstants(), true);
	}

	/**
	 * Get the value for a single enum key.
	 *
	 * @param string $key
	 *
	 * @throws \ReflectionException
	 * @return mixed
	 */
	public static function getValue(string $key)
	{
		return static::getConstants()[$key];
	}

	/**
	 * Get the description for an enum value.
	 *
	 * @param mixed $value
	 *
	 * @throws \ReflectionException
	 * @return string
	 */
	public static function getDescription($value): string
	{
		return humanize(camel2words(static::getKey($value)));
	}

	/**
	 * Get a random key from the enum.
	 *
	 * @throws \ReflectionException
	 * @return string
	 */
	public static function getRandomKey(): string
	{
		$keys = static::getKeys();

		return $keys[array_rand($keys)];
	}

	/**
	 * Get a random value from the enum.
	 *
	 * @throws \ReflectionException
	 * @return mixed
	 */
	public static function getRandomValue()
	{
		$values = static::getValues();

		return $values[array_rand($values)];
	}

	/**
	 * Return the enum as an array.
	 *
	 * [string $key => mixed $value]
	 *
	 * @throws \ReflectionException
	 * @return array
	 */
	public static function toArray(): array
	{
		return static::getConstants();
	}

	/**
	 * Get the enum as an array formatted for a select.
	 *
	 * [mixed $value => string description]
	 *
	 * @throws \ReflectionException
	 * @return array
	 */
	public static function toSelectArray(): array
	{
		$array       = static::toArray();
		$selectArray = [];

		foreach ($array as $value) {
			$selectArray[$value] = static::getDescription($value);
		}

		return $selectArray;
	}
}
