<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Employee as EmployeeResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\Project as ResourcesProject;
use App\Models\Employee;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        // dd(Auth::check());
        // dd(Auth::id());
        // dd(Auth::user());
        return view('auth.login');
    }

    public function login(Request $request) {
       

        $validator = Validator::make($request->all(), [ 
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);
        }
       
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $token = auth()->user()->createApiToken(); #Generate token
            return response()->json(['status' => 'Authorised', 'token' => $token ], 200);
        } else { 
            return response()->json(['status'=>'Unauthorised'], 401);
        } 
    }

    public function logout(Request $request)
    {
            // dd(Auth::logout());
            
            // $user = Auth::user();
            // // dd(auth()->user());
            // $user->api_token = null;
            // Session::flush();
            // Auth::logout();
            // // $user->save();
            // return redirect('login');
            // return $this->outputJSON(null,"Successfully Logged Out"); 

            if ($request->user()) { 
                $request->user()->api_tokens()->delete();
            }
        
            return response()->json(['message' => 'Successfully Logged Out'], 200);
    }

    // Session::flush();
        
    // Auth::logout();

    // return redirect('login');
    
        // $accessToken = auth()->user()->token();
        // $token= $request->user()->tokens->find($accessToken);
        // $token->revoke();
        // return response(['message' => 'You have been successfully logged out.'], 200);
        

    public function dashboard(Request $request) 
    {
        $countData = DB::select("SELECT (SELECT COUNT(*) FROM employees) as employee_count,
        (SELECT COUNT(*) FROM projects WHERE deleted_at IS NULL) as project_count,
        (SELECT COUNT(*) FROM projects WHERE status = 'open' AND deleted_at IS NULL) as open_projects,
        (SELECT COUNT(*) FROM projects WHERE status = 'pending' AND deleted_at IS NULL) as pending_projects,
        (SELECT COUNT(*) FROM projects WHERE status = 'hold' AND deleted_at IS NULL) as hold_projects,
        (SELECT COUNT(*) FROM projects WHERE status = 'rejected' AND deleted_at IS NULL) as rejected_projects,
        (SELECT COUNT(*) FROM projects WHERE status = 'closed' AND deleted_at IS NULL) as closed_projects")[0];  
       
    //    dd($countData->employee_count);
        //    dd($projects);
            if ($request->is('api/*')) {
                
                return new ResourcesProject($countData);
            }
            else
        return view('dashboard', ['countData' => $countData]);
    }
}







