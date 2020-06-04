@extends('layouts.app')

@section('content')
  <header class="flex items-center mb-4 py-4">
    <div class="flex justify-between items-center w-full">
      <h3 class="text-grey text-sm font-normal">My Projects</h3>
      <a href="/projects/create" class="button">New Project</a>
    </div>
  </header>

  <main class="lg:flex lg:flex-wrap -mx-3">
    @forelse ($projects as $project)
      <div class="lg:w-1/3 px-3 pb-6">
        <div class="bg-white p-5 rounded-lg shadow" style="height: 200px;">
          <h3 class="font-normal text-xl mb-3 py-4 -ml-5 border-l-4 border-blue-light pl-4">
            <a href="{{ $project->path() }}" class="no-underline text-black">{{ $project->title }}</a>
          </h3>

          <div class="text-grey">{{ Str::limit($project->description, 100) }}</div>
        </div>
      </div>
    @empty
      <div>No projects yet.</div>
    @endforelse
  </main>

@endsection