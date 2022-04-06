@extends('layout')
@section('content')
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center bg-primary text-white">
                        <h2>Project Crud</h2>
                    </div>
                    <br/>
                        <div class="table-responsive">
                            <div class="search-container">
                                <div class="form-inline md-form mr-auto mb-4">
                                <a class="pagination justify-content-center" >
                                <div class="d-flex">
                                    <form action="{{ route('searchProject') }}" method="PUT" role="search" class="d-flex ml-5">
                                        @csrf
                                        <div class="form-group row">
                                       <input type="text" placeholder="Search.." name="search"value="{{ $search ?? null }}" class="form-control  mr-sm-2  @error('search') is-invalid @enderror">
                                       @error('search')
                                    <div class="mt-2 alert alert-danger">{{ $message }}</div>
                                @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm btn aqua-gradient btn-rounded btn-sm my-0 mr-2 waves-effect waves-light">Search<i class="fa fa-search fa-sm"></i></button>
                                   <a  href="{{ route('project.index') }}" class="btn btn-success btn-sm btn aqua-gradient btn-rounded btn-sm my-0 waves-effect waves-light">Clear Search<i class="fa fa-search fa-sm"></i></a>
                                    </form>
                                </a>
                               </div>

                               {{-- <form action="{{ route('searchProject') }}" method="PUT" role="search" class="d-flex ml-5">
                                @csrf

                                            <div class="form-inline md-form mr-auto mb-4">
                                                <a class="pagination justify-content-center" >
                                
                                                       <div class="form-group row align-self-end" >
                                                            <label for="date" class=" col-sm-2 ">From :</label>
                                                            <div class="col-sm-3">
                                                                    <input type="date" class="form-control input-sm float-right" id="fromDate" name="fromDate" value="{{ $fromDate ?? null }}" required>
                                                            </div>
                                                            <label for="date" class="col-from-label col-sm-2 ">To :</label>
                                                            <div class="col-sm-3">
                                                                <input type="date" class="form-control input-sm float-right" id="toDate"  value="{{ $toDate ?? null }}"  name="toDate" required>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <button type="submit" class="btn btn-primary btn ml-4" name="search" title="Search">Filter</button>
                                                            </div>
                                                    </div>
                                    
                           
                                        </div>
                                    </a>
                              
                            </form> --}}

                            <form action="{{ route('searchProject') }}" method="PUT" role="search" class="form-inline ml-auto mr-5">
                                <div class="form-group mb-2">
                                  <label for="staticEmail2" class="mr-3">From :</label>
                                  <input type="date" class="form-control" id="fromDate" name="fromDate" value="{{ $fromDate ?? null }}">
                                </div>
                                <div class="form-group mx-sm-3 mb-2">
                                  <label for="inputPassword2" class="mr-3">To :</label>
                                  <input type="date" class="form-control" id="toDate" name="toDate" value="{{ $toDate ?? null }}" >
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Filter</button>
                              </form>

                            </div>
                               </div>

                            
                               
                            <table class="table">

                                 <script src="{{ asset('js/emp.js') }}" defer></script> 
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Technology</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($projects as $project)
                                    <tr>
                                           {{--
                                             The current loop iteration (starts at 1).
                                           When looping, a $loop variable will be available inside of your loop. 
                                           This variable provides access to some useful bits of information such as the current
                                            loop index and whether this is the first or last iteration through the loop:
                                             --}}
                                        <td>{{ $loop->iteration }}</td> 
                                        <td>{{ $project->name }}</td>
                                        <td>{{ $project->description }}</td>
                                        <td>{{ $project->status }}</td>
                                        <td>{{ $project->technology }}</td>
                                        <td>{{ $project->start_date }}</td>
                                        <td>{{ $project->end_date }}</td>
                                        <td>
                                            {{-- <a href="{{ url('/project/' . $project->id) }}" title="View Project"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a> --}}
                                            <a title="View Project"><button class="btn btn-info btn-sm" data-attr="{{ route('project.show', $project->id) }}" data-toggle="modal" id="smallButton" data-target="#smallModal"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/project/' . $project->id . '/edit') }}" title="Edit Project"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            <form method="POST" action="{{ url('/project' . '/' . $project->id) }}"  class="d-inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                               
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Project" onclick="return confirm('Are you sure want to Delete?')"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                {{$projects->links()}}
                               
                             </div>
                            <div class="card-body text-center">
                                <a href="{{ url('/project/create') }}" class="btn btn-success btn-sm" title="Add New Project">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Add New
                                </a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('js/emp.js')}}"></script>
    @endpush

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel"
    aria-hidden="true" >
    <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" id="smallBody">

                      </div> 
        </div>
    </div>
</div>
<script>
  $('document').ready(function() {
$(document).on('click', '#smallButton', function(event) {
      event.preventDefault();
      let href = $(this).attr('data-attr');
      $.ajax({
          url: href,
          beforeSend: function() {
            jQuery('#loader').show();
          },
          // return the result
          success: function(result) {
    
            jQuery.noConflict();
            $('#smallModal').modal("show");
            jQuery('#smallBody').html(result).show();
          },
          complete: function() {
            jQuery('#loader').hide();
          },
          error: function(jqXHR, testStatus, error) {
              console.log(error);
              alert("Page " + href + " cannot open. Error:" + error);
              jQuery('#loader').hide();
          },
          timeout: 8000
      })
  });
});
  // display a modal (small modal)
 
</script> 
@endsection