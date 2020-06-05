<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Project;
use Facades\Tests\Setup\ProjectFactory;

class ProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_guest_cannot_manage_project()
    {
        $project = factory('App\Project')->create();

        $this->get('/projects')->assertRedirect('/login');
        
        $this->get('/projects/create')->assertRedirect('/login');

        $this->get($project->path())->assertRedirect('/login');

        $this->post('/projects', $project->toArray())->assertRedirect('/login');
    }

    public function test_user_can_create_project()
    {
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph(1),
            'notes' => 'General notes here.'
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    public function test_user_can_update_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
             ->patch($project->path(), $attributes = ['notes' => 'Changed'])
             ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);
    }

    public function test_user_can_view_their_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    public function test_user_cannot_view_others_project()
    {
        $this->be(factory('App\User')->create());

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }

    public function test_authenticated_user_cannot_update_the_projects_of_others()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->patch($project->path())->assertStatus(403);      
    }

    public function test_project_require_title()
    {
        $this->signIn();

        $attributes = factory('App\Project')->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    public function test_project_require_description()
    {
        $this->signIn();

        $attributes = factory('App\Project')->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    public function test_project_belongs_to_owner()
    {
        $project = factory('App\Project')->create();

        $this->assertInstanceOf('App\User', $project->owner);
    }

}
