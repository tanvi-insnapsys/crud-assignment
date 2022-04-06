@extends('layout')
@section('content')
<div class="container">
<div class="card row mt-5">
  <h5 class="card-header text-center">Project Details</h5>
  <div class="card-body text-center">
        <div class="card-body">
        <h5 class="card-title">Project Name : {{ $project->name }}</h5>
        <p class="card-email">Description: {{ $project->description }}</p>
        <p class="card-text">Status : {{ $project->status }}</p>
        <p class="card-text">Technology : {{ $project->technology }}</p>
        <p class="card-text">Start Date : {{ $project->start_date }}</p>
        <p class="card-text">End Date : {{ $project->end_date }}</p>
        <div class="d-flex justify-content-center">
          <p class="card-text">Assigned Employees :</p>
          <ul class="text-left">
          
            @forelse ($projectEmployees as  $projectEmployees)
              <li>{{   $projectEmployees->user->name  }}</li>
            @empty
              
            @endforelse
          </ul>
        </div>
        <a class="btn btn-secondary mt-3" href="{{ route('project.index') }}">Back </a></br>
  </div>       
    </hr> 
  </div>
</div>