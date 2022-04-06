@extends('layout')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="card-header text-center font-weight-bold"> {{ isset($url) ? ucwords($url) : ""}} {{ __('Login') }}</div>
  {{-- <form method="POST" action="{{ route('login') }}"> --}}
    @isset($url)
    <form class="mt-5" method="POST" action='{{ route('employee-post-login') }}' aria-label="{{ __('Login') }}">
    @else
    <form class="mt-5" method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
    @endisset
      
    @csrf

    <div class="form-group">
      <label>E-mail</label>
      <input name="email" value="{{ old('email') }}" required 
        class="form-control{{ $errors->has('email') ? ' is-invalid': '' }}">

      @if ($errors->has('email'))
        <span class="invalid-feedback">
          <strong>{{ $errors->first('email') }}</strong>
        </span> 
      @endif
    </div>

    <div class="form-group">
      <label>Password</label>
      <input name="password" required type="password"
        class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}">

      @if ($errors->has('password'))
        <span class="invalid-feedback">
          <strong>{{ $errors->first('password') }}</strong>
        </span> 
      @endif
    </div>

    {{-- <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="remember"
            value="{{ old('remember') ? 'checked': '' }}">

          <label class="form-check-label" for="remember">
            Remember Me
          </label>
        </div>
    </div> --}}

    <button type="submit" class="col-2 mx-auto btn btn-success btn-block">Login!</button>
  </form>
  </div>
</div>
@endsection('content')

