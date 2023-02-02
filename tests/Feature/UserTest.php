<?php

namespace Tests\Feature;

use App\Enums\ActiveState;
use App\Mail\SendNewPasswordReset;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UserTest extends TestCase
{
	private $user;

	use DatabaseMigrations;

	protected function setUp(): void
	{
		parent::setUp();

		$this->user = factory(User::class)->create();
	}

	public function test_unauthorized_user_cannot_crud_user()
	{
		$this->withExceptionHandling()->unauthorizedUserSignIn();

		$this->get(route('users.index'))->assertStatus(403);

		$this->get(route('users.create'))->assertStatus(403);
		$this->get(route('users.edit', $this->user))->assertStatus(403);
		$this->post(route('users.destroy', $this->user), ['_method' => 'delete'])->assertStatus(403);
	}

	public function test_authorized_user_can_read_user()
	{
		$this->authorizedUserSignIn();

		$this->get(route('users.index'))->assertStatus(200);
	}

	public function test_authorized_user_can_create_user()
	{
		$this->authorizedUserSignIn();

		$this->get(route('users.create'))->assertStatus(200);

		$user = make(User::class);

		$password = 'Cloudteam@123';

		$this->post(route('users.store'), array_merge($user->toArray(), [
			'password'              => $password,
			'password_confirmation' => $password,
		]))->assertStatus(302);
	}

	public function test_authorized_user_can_edit_user()
	{
		$this->authorizedUserSignIn();

		$this->get(route('users.edit', $this->user))
		     ->assertStatus(200)
		     ->assertSee($this->user->title);

		$user = create(User::class);

		$password = 'Cloudteam@1234';

		$this->put(route('users.update', $user), array_merge($user->toArray(), [
			'password'              => $password,
			'password_confirmation' => $password,
		]))->assertStatus(302);

		$this->assertDatabaseHas('users', [
			'id' => $user->id,
		]);
	}

	public function test_authorized_user_can_delete_user()
	{
		$this->authorizedUserSignIn();

		$user = create(User::class, null);

		$this->delete(route('users.destroy', $user))->assertStatus(200);

		$this->assertSoftDeleted('users', [
			'id' => $user->id,
		]);
	}

	public function test_authorized_user_can_delete_multiple_user()
	{
		$this->authorizedUserSignIn();

		$user1 = create(User::class, null);
		$user2 = create(User::class, null);

		$this->delete(route('users.destroys', [
			'ids' => [$user1->id, $user2->id],
		]))->assertStatus(200);

		$this->assertSoftDeleted('users', [
			'id' => $user1->id,
		]);

		$this->assertSoftDeleted('users', [
			'id' => $user2->id,
		]);
	}

	public function test_inactive_user_muts_be_kick_out()
	{
		$this->withExceptionHandling()->authorizedUserSignIn($this->user);

		$this->get(route('home'))->assertStatus(200);

		$this->user->update(['state' => 0]);

		$this->get(route('home'))->assertStatus(403);
	}

	public function test_authorized_user_can_change_password()
	{
		$this->authorizedUserSignIn();

		$currentPassword = 'Oldpass@123';
		$newPassword     = 'Newpass@123';

		$user = create(User::class, null, [
			'password' => \Hash::make($currentPassword),
		]);

		$this->actingAs($user);

		$this->post(route('users.change_password', $user), [
			'current_password'      => $currentPassword,
			'password'              => $newPassword,
			'password_confirmation' => $newPassword,
		])->assertStatus(200);

		$user = $user->fresh();

		$this->assertTrue(\Hash::check($newPassword, $user->password));
	}

	public function test_authorized_user_can_reset_other_user_password()
	{
		$this->authorizedUserSignIn();
		Mail::fake();

		$currentPassword = 'Oldpass@123';
		$newPassword     = 'Newpass@123';

		$user = create(User::class, null, [
			'password' => \Hash::make($currentPassword),
		]);

		$this->post(route('users.reset_default_password', $user))->assertStatus(200);

		$user = $user->fresh();

		$this->assertFalse(\Hash::check($newPassword, $user->password));
	}

	public function test_authorized_user_can_change_other_user_state()
	{
		$this->authorizedUserSignIn();

		$user = create(User::class, null, [
			'state' => ActiveState::INACTIVE,
		]);

		$this->post(route('users.change_state', $user), [
			'state' => ActiveState::ACTIVE,
		])->assertStatus(200);

		$user = $user->fresh();

		$this->assertEquals($user->state, ActiveState::ACTIVE);
	}
}
