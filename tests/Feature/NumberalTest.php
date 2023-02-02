<?php

namespace Tests\Feature;

use App\Models\Numberal;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class NumberalTest extends TestCase {
	private $numberal;

	use DatabaseMigrations;

	protected function setUp(): void {
		parent::setUp();

		$this->numberal = factory( Numberal::class )->create();
	}

	public function test_unauthorized_user_cannot_crud_numberal() {
		$this->withExceptionHandling()->unauthorizedUserSignIn();

		$this->get( route( 'numberals.index' ) )->assertStatus( 403 );

		$this->get( route( 'numberals.create' ) )->assertStatus( 403 );

		$this->get( route( 'numberals.edit', $this->numberal ) )->assertStatus( 403 );

		$this->post( route( 'numberals.destroy', $this->numberal ), ['_method' => 'delete'] )->assertStatus( 403 );
	}

	public function test_authorized_user_can_read_numberal() {
		$this->authorizedUserSignIn();

		$this->get( route( 'numberals.index' ) )->assertStatus( 200 );
	}

	public function test_authorized_user_can_create_numberal() {
		$this->authorizedUserSignIn();

		$this->get( route( 'numberals.create' ) )->assertStatus( 200 );

		$numberal = make(Numberal::class);
		$this->post( route( 'numberals.store' ), $numberal->toArray() )->assertRedirect( route( 'numberals.index') );
	}

	public function test_authorized_user_can_edit_numberal() {
		$this->authorizedUserSignIn();

		$this->get( route( 'numberals.edit', $this->numberal ) )
		     ->assertStatus( 200 )
		     ->assertSee( $this->numberal->title );

		$numberal = create(Numberal::class);

		$this->put( route( 'numberals.update', $numberal ), $numberal->toArray())
		    ->assertRedirect( route( 'numberals.index') );

		$this->assertDatabaseHas( 'numberals', [
			'id' => $numberal->id
		] );
	}

	public function test_authorized_user_can_delete_numberal() {
		$this->authorizedUserSignIn();

		$numberal = create( Numberal::class );

		$this->delete( route( 'numberals.destroy', $numberal ))->assertStatus( 200 );

		$this->assertSoftDeleted( 'numberals', [
			'id' => $numberal->id
		] );
	}

	public function test_authorized_user_can_delete_multiple_numberal() {
  		$this->authorizedUserSignIn();

  		$numberal1 = create( Numberal::class);
  		$numberal2 = create( Numberal::class);

  		$this->delete( route( 'numberals.destroys', [
  			'ids' => [$numberal1->id, $numberal2->id]
  		] ) )->assertStatus( 200 );

  		$this->assertSoftDeleted( 'numberals', [
  			'id' => $numberal1->id
  		] );

  		$this->assertSoftDeleted( 'numberals', [
  			'id' => $numberal2->id
  		] );
  	}
}
