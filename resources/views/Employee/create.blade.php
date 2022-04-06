@extends('layout')
@section('content')
<div class="container">
<div class="card row mt-5">
  <h4 class="card-header text-center">Employee Page</h4>
  <div class="card-body">
      
      <form action="{{ url('employee') }}" method="post">
        {!! csrf_field() !!}

        {{-- @include('partials.employee_form') --}}

        <label>Name :</label></br>
        <input type="text" name="name" id="name" value="{{ old('name', $employee->name) }}" placeholder="Enter your Name" class="form-control @error('name') is-invalid @enderror">
        @error('name')
        <div class="mt-2 alert alert-danger">{{ $message }}</div>
    @enderror
      </br>

        <label>Email :</label></br>
        <input type="text" name="email" id="email" value="{{ old('email', $employee->email) }}" placeholder="Enter your Email Address" class="form-control @error('email') is-invalid @enderror">
        @error('email')
        <div class="mt-2 alert alert-danger">{{ $message }}</div>
    @enderror
      </br>

        <label>Mobile No :</label></br>
        <input type="text" name="mobile" id="mobile" value="{{ old('mobile', $employee->mobile) }}" placeholder="Enter your Mobile Number" class="form-control @error('mobile') is-invalid @enderror">
        @error('mobile')
        <div class="mt-2 alert alert-danger">{{ $message }}</div>
    @enderror
      </br>

        <label>DOB :</label></br>
        <input type="date" name="dob" id="dob" onclick="function()" value="{{ old('dob', $employee->dob) }}"  class="form-control datepicker @error('dob') is-invalid @enderror">
        @error('dob')
        <div class="mt-2 alert alert-danger">{{ $message }}</div>
    @enderror
      </br>
        
        <label>Designation :</label></br>
        <input type="text" name="designation" id="designation" value="{{ old('designation', $employee->designation) }}" placeholder="Enter your Designation" class="form-control @error('designation') is-invalid @enderror">
        @error('designation')
        <div class="mt-2 alert alert-danger">{{ $message }}</div>
    @enderror
      </br>

        <label>DOJ :</label></br>
        <input type="date" name="doj" id="doj" value="{{ old('doj', $employee->doj) }}" class="form-control @error('doj') is-invalid @enderror">
        @error('doj')
        <div class="mt-2 alert alert-danger">{{ $message }}</div>
    @enderror
      </br>

        <button type="submit" class="btn btn-success">Save</button>
        <a class="btn btn-secondary" href="{{ route('employee.index') }}">Cancel </a></br>
    </form>
 
  
  </div>
</div>
</div>
@endsection