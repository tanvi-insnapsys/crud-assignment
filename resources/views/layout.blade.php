<!DOCTYPE html>
<html>
<head>
    {{-- <title>Project CRUD</title> --}}
    
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    {{-- <script src="http://code.jquery.com/jquery-3.4.1.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
    <script src="{{ asset('js/app.js') }}" ></script>
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="jquery-3.5.1.min.js"></script> --}}
</head>
<body>

    
@yield('javascript')

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        {{-- <h5 class="my-0 mr-md-auto font-weight-normal">Laravel Blog</h5> --}}
        <nav class="my-2 my-md-0 mr-md-3">
     {{-- @dump(Auth::check()) --}}

            @guest

            @else
                <a  href="{{ route('logout') }}" class="p-2"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                    >Logout ({{ Auth::user()->name }})</a>

                <form id="logout-form" action={{ route('logout') }} method="POST"
                    style="display: none;">
                    
                    @csrf
                </form>
            <a class="mx-3" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="mx-3" href="{{ route('project.index') }}">Projects</a>
            @endguest
        </nav>
    </div>

    {{-- <div class="container"> --}}
        @if(session()->has('status'))
            <p style="color: green">
                {{ session()->get('status') }}
            </p>
        @endif

        @yield('content')
    {{-- </div> --}}
    
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>