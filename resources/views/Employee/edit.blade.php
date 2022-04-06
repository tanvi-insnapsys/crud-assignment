@extends('layout')
@section('content')
<div class="container">
<div class="card row mt-5">
  <h5 class="card-header text-center">Update Employee Details</h5>
  <div class="card-body">
      
      <form action="{{ url('employee/' .$employee->id) }}" method="post">
        {!! csrf_field() !!}

        
        @include('partials.employee_form')
        <input type="hidden" name="id" id="id" value="{{$employee->id}}" id="id" />

        
        <button type="submit" class="btn btn-success">Update</button>
        {{-- <button type="button" class="btn btn-secondary">Cancel</button> --}}
        <a class="btn btn-secondary" href="{{ route('employee.index') }}">Cancel </a></br>
          
    </form>
   
  </div>
</div>
 </div>
@endsection