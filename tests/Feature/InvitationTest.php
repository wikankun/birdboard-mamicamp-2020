<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_project_can_invite_a_user()
    {
        $project = ProjectFactory::create();

        $project->invite($newUser = factory(User::class)->create());

        $this
            ->actingAs($newUser)
            ->post(action('ProjectTaskController@store', $project), $task = ['body' => 'Foo task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
