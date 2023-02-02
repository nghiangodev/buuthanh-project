<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase {
	private $role;

	use DatabaseMigrations;

	protected function setUp(): void {
		parent::setUp();

		$this->role = factory( Role::class )->create();
	}

	public function test_unauthorized_user_cannot_crud_role() {
		$this->withExceptionHandling()->unauthorizedUserSignIn();

		$this->get( route( 'roles.index' ) )->assertStatus( 403 );

		$this->get( route( 'roles.create' ) )->assertStatus( 403 );

		$this->get( route( 'roles.edit', $this->role->id ) )->assertStatus( 403 );

		$this->get( route( 'roles.show', $this->role->id ) )->assertStatus( 403 );

		$this->post( route( 'roles.destroy', $this->role->id ), ['_method' => 'delete'] )->assertStatus( 403 );
	}

	public function test_authorized_user_can_read_role() {
		$this->authorizedUserSignIn();

		$this->get( route( 'roles.index' ) )->assertStatus( 200 );
	}

	public function test_authorized_user_can_create_role() {
		$this->authorizedUserSignIn();

		$this->get( route( 'roles.create' ) )->assertStatus( 200 );

		$role = make(Role::class);
		$this->post( route( 'roles.store' ), $role->toArray() )
		     ->assertRedirect( route( 'roles.index' ) );
	}

	public function test_authorized_user_can_edit_role() {
		$this->authorizedUserSignIn();

		$this->get( route( 'roles.edit', $this->role->id ) )
		     ->assertStatus( 200 )
		     ->assertSee( $this->role->title );

		$role = create(Role::class);

		$this->put( route( 'roles.update', $role->id ), $role->toArray())->assertRedirect( route( 'roles.index' ) );

		$this->assertDatabaseHas( 'roles', [
			'id' => $role->id
		] );
	}

	public function test_authorized_user_can_delete_role() {
		$this->authorizedUserSignIn();

		$role = create( Role::class );

		$this->delete( route( 'roles.destroy', $role->id ))->assertStatus( 200 );

		$this->assertDatabaseMissing( 'roles', [
			'id' => $role->id
		] );
	}

	public function test_authorized_user_can_delete_multiple_role() {
		$this->authorizedUserSignIn();

		$role1 = create( Role::class, null );
		$role2 = create( Role::class, null );

		$this->delete( route( 'roles.destroys', [
			'ids' => [$role1->id, $role2->id]
		] ) )->assertStatus( 200 );

		$this->assertDatabaseMissing( 'roles', [
			'id' => $role1->id
		] );

		$this->assertDatabaseMissing( 'roles', [
			'id' => $role2->id
		] );
	}
}
