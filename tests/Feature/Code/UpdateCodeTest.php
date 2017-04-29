<?php

namespace Tests\Feature\Dataset;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateCodeTest extends TestCase
{
    use DatabaseMigrations;
    private $user;
    private $code;

    public function setUp ()
    {
        parent::setUp();
        $this->user    = create('App\User');
        $this->code = create('App\Code', ['user_id' => $this->user->id ]);
    }

    /** @test */
    public function guests_may_not_edit_codes ()
    {
        $this->get($this->code->path() . '/edit')
             ->assertRedirect('/login');

        $this->put($this->code->path())
             ->assertRedirect('/login');
    }

    /** @test */
    public function any_authenticated_user_may_not_view_edit_code_page ()
    {
        $this->disableExceptionHandling()->signIn();

        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->get($this->code->path() . '/edit');
    }

    /** @test */
    public function any_authenticated_user_may_not_edit_code ()
    {
        $this->disableExceptionHandling()->signIn();

        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->put($this->code->path());
    }

    /** @test */
    public function creator_may_edit_code ()
    {
        $this->disableExceptionHandling()->signIn($this->user);

        $this->get($this->code->path() . '/edit')
             ->assertStatus(200);

        $this->expectException('Illuminate\Validation\ValidationException');
        $this->put($this->code->path());
    }

    /** @test */
    public function admin_may_edit_code ()
    {
        $this->disableExceptionHandling()->signIn($this->createAdmin());

        $this->get($this->code->path() . '/edit')
             ->assertStatus(200);

        $this->expectException('Illuminate\Validation\ValidationException');
        $this->put($this->code->path());
    }

    /** @test */
    public function a_code_requires_a_valid_name ()
    {
        $this->updateCode(['name' => null])
             ->assertSessionHasErrors('name');

        $this->updateCode(['name' => str_random(5)])
             ->assertSessionHasErrors('name');

        $this->updateCode(['name' => str_random(51)])
             ->assertSessionHasErrors('name');

        $this->updateCode(['name' => str_random(20)])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_code_requires_a_valid_description ()
    {
        $this->updateCode(['description' => null])
             ->assertSessionHasErrors('description');

        $this->updateCode(['description' => str_random(20001)])
             ->assertSessionHasErrors('description');

        $this->updateCode(['description' => str_random(1000)])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_code_requires_a_valid_code ()
    {
        $this->updateCode(['code' => null])
             ->assertSessionHasErrors('code');

        $this->updateCode(['code' => str_random(50001)])
             ->assertSessionHasErrors('code');

        $this->updateCode(['code' => str_random(1000)])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_code_requires_valid_publish_boolean ()
    {
        $this->updateCode(['publish' => 'string'])
             ->assertSessionHasErrors('publish');

        $this->updateCode(['publish' => true])
             ->assertSessionMissing('errors');
    }

    protected function updateCode ($overrides = [])
    {
        $this->signIn($this->user);
        $this->code->fill(raw('App\Code', $overrides));

        return $this->put($this->code->path(), $this->code->toArray());
    }
}
