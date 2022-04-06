@extends('layout')
@section('content')
<div class="container">
<div class="card row mt-5">
  <h5 class="card-header text-center">Employee Page</h5>
  <div class="card-body text-center">
        <div class="card-body">
        <h5 class="card-title">Name : {{ $employee->user->name }}</h5>
        <p class="card-email">Email : {{ $employee->user->email }}</p>
        <p class="card-text">Mobile : {{ $employee->mobile }}</p>
        <p class="card-text">DOB : {{ $employee->dob }}</p>
        <p class="card-text">Designation : {{ $employee->designation }}</p>
        <p class="card-text">DOJ : {{ $employee->doj }}</p>
        <div class="d-flex justify-content-center">
          <p class="card-text">Assigned Projects :</p>
          <ul class="text-left">
            @forelse ($employeeProjects as  $employeeProject)
              <li>{{   $employeeProject->name  }}</li>
            @empty
              
            @endforelse
          </ul>
        </div>
        <a class="btn btn-secondary mt-3" href="{{ route('employee.index') }}">Back </a></br>
  </div>
       
    </hr>
  
  </div>
</div>