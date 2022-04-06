@extends('layout')
@section('content')
<div class="container">
<div class="card row mt-5">
  <h5 class="card-header text-center">Update Project Details</h5>
  <div class="card-body">
      
      <form action="{{ url('project/' .$project->id) }}" method="post">
        {!! csrf_field() !!}
        @method("PATCH")
        @include('Project.partials.form')
        <input type="hidden" name="id" id="id" value="{{$project->id}}" id="id" />

        <button type="submit" class="btn btn-success">Update</button>
        {{-- <button type="button" class="btn btn-secondary">Cancel</button> --}}
        <a class="btn btn-secondary" href="{{ route('project.index') }}">Cancel </a></br>
          
    </form>
   
  </div>
</div>
 </div>
@endsection