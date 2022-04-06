@extends('layout')
@section('content')
<div class="container">
<div class="card row mt-5">
  <h4 class="card-header text-center">Project Page</h4>
  <div class="card-body">
      
      <form action="{{ url('project') }}" method="post">
        {!! csrf_field() !!}

        @include('Project.partials.form')

         <button type="submit" class="btn btn-success">Save</button>
        <a class="btn btn-secondary" href="{{ route('project.index') }}">Cancel </a></br>
    </form>
     
  </div>
</div>
</div>
@endsection