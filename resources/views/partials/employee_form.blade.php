@extends('layout')
@section('content')
<div class="container">
<div class="card row mt-5">
  <h4 class="card-header text-center">Employee Page</h4>
  <div class="card-body">
      <h2>{{ isset($employee) ? 'Edit record' : 'Create new record' }}</h2>
      <form action="{{ isset($employee) ? '/employee/'.$employee->id : '/employee' }}" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}

        @if ($employee ?? false)
        @method("PATCH")
        @endif
       
        {{-- @include('partials.employee_form') --}}

        <label>Name :</label></br>
        <input type="text" name="name" id="name" value="{{ old('name', $employee->user->name ?? null) }}" placeholder="Enter your Name" class="form-control @error('name') is-invalid @enderror">
        @error('name')
        <div class="mt-2 alert alert-danger">{{ $message }}</div>
    @enderror
      </br>

        <label>Email :</label></br>
        <input type="text" name="email" id="email" value="{{ old('email', $employee->user->email ?? null) }}" placeholder="Enter your Email Address" class="form-control @error('email') is-invalid @enderror">
        @error('email')
        <div class="mt-2 alert alert-danger">{{ $message }}</div>
    @enderror
      </br>

      <label>Password :</label></br>
        <input type="password" name="password" id="password" value="{{ old('password', $employee->user->password ?? null) }}" placeholder="Enter your Password" class="form-control @error('password') is-invalid @enderror">
        @error('password')
        <div class="mt-2 alert alert-danger">{{ $message }}</div>
    @enderror
      </br>

        <label>Mobile No :</label></br>
        <input type="text" name="mobile" id="mobile" value="{{ old('mobile', $employee->mobile ?? null) }}" placeholder="Enter your Mobile Number" class="form-control @error('mobile') is-invalid @enderror">
        @error('mobile')
        <div class="mt-2 alert alert-danger">{{ $message }}</div>
    @enderror
      </br>

        <label>DOB :</label></br>
        <input type="date" name="dob" id="dob"  value="{{ old('dob', $employee->dob ?? null) }}"  class="form-control datepicker @error('dob') is-invalid @enderror">
        @error('dob')
        <div class="mt-2 alert alert-danger">{{ $message }}</div>
    @enderror
      </br>
        
        <label>Designation :</label></br>
        <input type="text" name="designation" id="designation" value="{{ old('designation', $employee->designation ?? null) }}" placeholder="Enter your Designation" class="form-control @error('designation') is-invalid @enderror">
        @error('designation')
        <div class="mt-2 alert alert-danger">{{ $message }}</div>
    @enderror
      </br>

        <label>DOJ :</label></br>
        <input type="date" name="doj" id="doj" value="{{ old('doj', $employee->doj ?? null) }}" class="form-control @error('doj') is-invalid @enderror">
        @error('doj')
        <div class="mt-2 alert alert-danger">{{ $message }}</div>
    @enderror
      </br>

<label>Profile Picture :</label></br>
     @if ($employee ?? false)
        <img src="{{ asset('uploads/'.$employee->profile_picture) }}" width="auto" height="100px"/></br></br>
     @endif
           {{-- 
      <input type="file" name="profile_picture" class="form-control" class="form-control @error('profile_picture') is-invalid @enderror">
      @error('profile_picture')
      <div class="mt-2 alert alert-danger">{{ $message }}</div>
  @enderror  --}}

    {{-- </br>
  </br> --}}
  <div class="container">
  
    <div id="dropzonewidget" class="dropzone" content="{{ csrf_token() }}" >
      <div class="dz-default dz-message"><h4>Please Drag & Drop Your File</h4></div>
</div>
</div>
</br>
</br>

        <button type="submit" class="btn btn-success">{{ isset($employee) ? 'Update' : 'Save' }}</button>
        {{-- <button type="submit" class="btn btn-success">Update</button> --}}
        <a class="btn btn-secondary" href="{{ route('employee.index') }}">Cancel </a></br>
    </form>
      <script>
      //   var segments = location.href.split('/');
      //   var action = segments[4];
      //   console.log(action);
      //  // if (action == 'dropzone') {
      //       var acceptedFileTypes = "image/*, .psd"; //dropzone requires this param be a comma separated list
      //       var fileList = new Array;
      //       var i = 0;
      //       var callForDzReset = false;

            var uploadedfilename = '';
            var CSRF_TOKEN = $('#dropzonewidget').attr('content');
            var myDropzone = new Dropzone("div#dropzonewidget", { 
                url: "/document_upload",
                addRemoveLinks: true,
                maxFiles:1,
                acceptedFiles: 'image/*',
                maxFilesize: 2048,
                sending: function(file, xhr, formData) {
                  formData.append("_token", CSRF_TOKEN);  

                  this.on("removedfile", function(file) {
                    console.log(file.name);
                    var postData ={
                    _token :CSRF_TOKEN,
                    uploadedfilename : uploadedfilename,
                           // fileName:  'fileName'
                    }
                   jQuery.ajax({
                      url: '/remove_tempfile',
                      type:   "post",
                      data: postData,
                      success: function(data) {
                        if(data.result===true){
                                    // File removed successfully
                                    console.log('File deleted successfully');
                        }
                      }
                    });

                });

                this.on("success", function(file, response) {
                //var obj = jQuery.parseJSON(response)
                console.log(response);
               uploadedfilename = response;

            })
                },
            });

          //  $("#dob").datepicker({ dateFormat: 'yy-mm-dd' });

      </script>
  </div>
</div>
</div>
@endsection