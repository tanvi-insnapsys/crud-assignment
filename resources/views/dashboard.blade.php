@extends('layout')
@section('content')
<div class="container-fluid bg-dark mt-5">
        {{-- @dump($countData) --}}
        <div class="row justify-content-center my-auto">
        {{-- <div class="col-sm-9"> --}}
                <div class="card  bg-light mb-3 mx-3" style="max-width: 18rem;">
                <h4 class="card-header">Open Projects</h4>
                <div class="card-body">
                <h1 class="card-title">{{ $countData->open_projects }}</h1>  
                </div>
        </div>
        <div class="card  bg-light mb-3 mx-3" style="max-width: 18rem;">
                <h4 class="card-header">Pending Projects</h4>
                <div class="card-body">
                <h1 class="card-title">{{ $countData->pending_projects }}</h1>  
                </div>
        </div>
        <div class="card  bg-light mb-3 mx-3" style="max-width: 18rem;">
                <h4 class="card-header">Projects on Hold</h4>
                <div class="card-body">
                <h1 class="card-title">{{ $countData->hold_projects }}</h1>  
                </div>
        </div>
        <div class="card  bg-light mb-3 mx-3" style="max-width: 18rem;">
                <h4 class="card-header">Closed Projects</h4>
                <div class="card-body">
                <h1 class="card-title">{{ $countData->rejected_projects }}</h1>  
                </div>
        </div>
        <div class="card  bg-light mb-3 mx-3" style="max-width: 18rem;">
                <h4 class="card-header">Rejected Projects </h4>
                <div class="card-body">
                <h1 class="card-title">{{ $countData->closed_projects}}</h1>  
                </div>
        </div>
        {{-- </div> --}}
        </div>
        <div class="row justify-content-center">
        
                <div class="card bg-light mb-3 mx-3" style="max-width: 18rem;">
                        <h4 class="card-header">Projects</h4>
                        <div class="card-body">
                        <h1 class="card-title">{{ $countData->project_count }}</h1>  
                        </div>
                </div>
                <div class="card bg-light mb-3 mx-3" style="max-width: 18rem;">
                        <h4 class="card-header">Employees</h4>
                        <div class="card-body">
                        <h1 class="card-title">{{ $countData->employee_count }}</h1>  
                        </div>
                </div>
        </div>
        <div class="text-center">
        <a class="btn btn-secondary mt-3" href="{{ route('employee.index') }}">Back </a></br>
</div>
</div>
      @endsection