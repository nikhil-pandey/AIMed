<?php

namespace Tests\Feature\Discussion;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateReplyTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    private $user;
    private $discussion;
    private $reply;

    public function setUp ()
    {
        parent::setUp();
        $this->user    = create('App\User');
        $this->discussion    = create('App\Thread');
        $this->reply = create('App\Reply', ['user_id' => $this->user->id, 'thread_id' => $this->discussion->id ]);
    }

    /** @test */
    public function guests_may_not_edit_replies ()
    {
        $this->get($this->reply->path() . '/edit')
             ->assertRedirect('/login');

        $this->put($this->reply->path())
             ->assertRedirect('/login');
    }

    /** @test */
    public function any_authenticated_user_may_not_view_edit_reply_page ()
    {
        $this->disableExceptionHandling()->signIn();

        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->get($this->reply->path() . '/edit');
    }

    /** @test */
    public function any_authenticated_user_may_not_edit_reply ()
    {
        $this->disableExceptionHandling()->signIn();

        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->put($this->reply->path());
    }

    /** @test */
    public function creator_may_edit_reply ()
    {
        $this->disableExceptionHandling()->signIn($this->user);

        $this->get($this->reply->path() . '/edit')
             ->assertStatus(200);

        $this->expectException('Illuminate\Validation\ValidationException');
        $this->put($this->reply->path());
    }

    /** @test */
    public function a_reply_requires_a_valid_body()
    {
        $this->updateReply(['body' => null])
             ->assertSessionHasErrors('body');

        $this->updateReply(['body' => str_random(5001)])
             ->assertSessionHasErrors('body');

        $this->updateReply(['body' => str_random(1000)])
             ->assertSessionMissing('errors');
    }

    protected function updateReply ($overrides = [])
    {
        $this->signIn($this->user);
        $this->reply->fill(raw('App\Reply', $overrides));

        return $this->put($this->reply->path(), $this->reply->toArray());
    }
}
