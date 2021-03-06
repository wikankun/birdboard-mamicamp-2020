<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Project extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    // public $old = [];

    public function path()
    {
        return "/projects/{$this->id}";
    }
    
    public function owner()
	{
		return $this->belongsTo(User::class);
    }
    
    public function tasks()
    {
       return $this->hasMany(Task::class);
    }

    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
    }
    
    public function addTasks($tasks)
    {
        return $this->tasks()->createMany($tasks);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function invite(User $user)
    {
        $this->members()->attach($user);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members')->withTimestamps();
    }

    // public function recordActivity($description)
    // {
    //     $this->activity()->create([
    //         'description' => $description,
    //         'changes' => $this->activityChanges($description)
    //     ]);
    // }

    // protected function activityChanges($description)
    // {
    //     if ($description == 'updated') {
    //         return [
    //             'before' => Arr::except(array_diff($this->old, $this->getAttributes()), 'updated_at'),
    //             'after' => Arr::except($this->getChanges(), 'updated_at')
    //         ];
    //     }
    // }
}
