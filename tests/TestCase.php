<?php

namespace Tests;

use App\Exceptions\Handler;
use App\Models\User;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Role;

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication;

	protected function setUp(): void
	{
		parent::setUp();

		$this->seed(\DatabaseSeeder::class);

		$this->disableExceptionHandling();
	}

	/**
	 * @param null $user
	 *
	 * @return $this
	 */
	protected function authorizedUserSignIn($user = null)
	{
		/** @var User $user */
		if ($user === null) {
			$user = User::find(1);
		}

		$this->actingAs($user);

		return $this;
	}

	/**
	 * @return $this
	 */
	protected function unauthorizedUserSignIn()
	{
		/** @var User $user */
		$user = factory(User::class)->create();

		$role = Role::create(['name' => 'dummy']);

		$user->assignRole($role->name);

		$this->actingAs($user);

		return $this;
	}

	protected function disableExceptionHandling()
	{
		$this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);
		$this->app->instance(ExceptionHandler::class, new class extends Handler
		{
			/** @noinspection PhpMissingParentConstructorInspection */
			public function __construct()
			{
			}

			public function report(\Throwable $e)
			{
			}

			public function render($request, \Throwable $e)
			{
				throw $e;
			}
		});
	}

	protected function withExceptionHandling()
	{
		$this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);

		return $this;
	}
}
