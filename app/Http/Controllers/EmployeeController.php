<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Employee as EmployeeResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class EmployeeController extends Controller  
{
    public function dropzone() {
        return view('dropzone');
    }

    public function __construct()
    {
        // $this->middleware('auth:employees');
    }

    public function index(Request $request)
    {
        // $user = Employee::all();
        $pageSize = $request->pageSize;
        if(empty($pageSize)) {
            $pageSize = config('app.global_page_size');
        }
       if ($request->search) {
        return $this->applySearch($request);
       }
       else{
        // $employees = Employee::paginate($pageSize);
        $employees = Employee::select('id','user_id','mobile','dob','designation','doj','profile_picture')->with('user')->paginate($pageSize);

        // foreach ($employees as $key => $employeeItem) {
        //     $employeeItem->name =$employeeItem->user->name;
        //     $employeeItem->email =$employeeItem->user->email;
        // }
    
        if ($request->is('api/*')) {
            
            return new EmployeeResource($employees);
        }
       else
       $user = Auth::user();
       if ($user != null) {
        if($user->employee->designation == "Admin"){
            // $employees = Employee::paginate(2);
         return view ('employee.index')->with('employees', $employees);
         }
         else {
             $employee = Employee::where('user_id', $user->id)->paginate($pageSize);
 
             if ($request->is('api/*')) {
                 return new EmployeeResource($employee);
             }
            else
             return view ('employee.index')->with('employees', $employee);
             }
       }
       else{
        return back();
       }
       }
    }

    public function search(Request $request)
    { 
        if($request->search){
            // dd($request);
            return $this->applySearch($request);
        }
 }

 public function applySearch($request)
{ 
            $pageSize = $request->pageSize;
            $request->validate([
                'search'=>'required|string',
            ]);
            if($request->search != null){
            $userIds = User::where('name','like', '%' .$request->search. '%')
                                        ->orWhere('email','like', '%' .$request->search. '%')
                                        ->get()->pluck('id')->toArray();
                                    
            $employees = Employee::whereIn('user_id', $userIds)->orWhere('mobile','like', '%' .$request->search. '%')->with('user')->paginate($pageSize);
            $employees->appends(['search' => $request->search]);
            
            if(count($employees)>0){
                if ($request->is('api/*')) {
                    return new EmployeeResource([$employees]);
                }
                else
                return view('employee.index',['employees'=>$employees ,'search' =>$request->search ]);
            }
            return back()->with('error','No results Found');
        }
 }

    public function create()
    {
        return view('partials.employee_form');
    }
  
    public function store(Request $request)
    {
        // dd($request);
        if ($request->is('api/*')) {
            $validator = Validator::make($request->all(), [
                'name'=>'required|string',
                'email' => 'required|email:rfc,dns|unique:users,email',
                'password' => 'required|string|min:8',
                'mobile'=>' required|digits:10|unique:employees,mobile',
                'dob'=>'required|date_format:Y-m-d',
                'designation'=>'required|string',
                'doj'=>'required|date_format:Y-m-d',
              ]);
      
              if ($validator->fails()) {
                  return response()->json([
                    'errors' => $validator->errors(),
                    'status' => Response::HTTP_BAD_REQUEST,
                  ], Response::HTTP_BAD_REQUEST);
              }
        }       
        else {
         
        $request->validate([
            'name'=>'required|string',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|string|min:8',
            'mobile'=>' required|digits:10|unique:employees,mobile',
            'dob'=>'required|date_format:Y-m-d',
            'designation'=>'required|string',
            'doj'=>'required|date_format:Y-m-d',
            // 'profile_picture' => 'nullable|mimes:jpeg,bmp,png,jpg|max:2048',
        ]);
        // dd($request);
    }
        
        $input = $request->all();
        // dd($input);
        // check if file present or not
        // if($request->file()) {
        //     $fileName = time().'_'.$request->profile_picture->getClientOriginalName();
        //     $request->file('profile_picture')->move('uploads', $fileName);
        //     $input['profile_picture'] =  $fileName;
        // }
        
        // $tempFile = File::files(public_path().'/temp')[0];
        // $tempFileName = $tempFile->getFilename();
        // File::move(public_path(). '/temp'. '/' . $tempFileName, public_path(). '/uploads'. '/' . $tempFileName);
        // $input['profile_picture'] =  $tempFileName;
        $user =  User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
        ]);

        $employee =  Employee::create([
            'mobile' => $input['mobile'],
            'dob' => $input['dob'],
            'designation' => $input['designation'],
            'doj' => $input['doj'],
            'user_id' => $user->id,       
         ]);
        //  $employee = Employee::with('user');
        // $employeeProjects = $employee->project;
        $employee->user;

        // if ($request->ajax()) {
            if ($request->is('api/*')) {
            return new EmployeeResource($employee);
        }
       else
        return redirect('employee')->with('flash_message', 'Employee Addedd!');  
    }
    
    public function show(Request $request, $id)
    { 
        $employee = Employee::with('user')->find($id);
        $employeeProjects = $employee->project;
        if ($request->is('api/*')) {
            return new EmployeeResource($employee);
        }
       else
        return view('employee.show',['employee' => $employee, 'employeeProjects' => $employeeProjects]);
    }
    
    public function edit(Request $request, $id)
    { 
        $employee = Employee::find($id);
        return view('partials.employee_form', compact('employee'))->with('employee', $employee);
    }
  
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        $user = User::where('id', $employee->user_id)->first();

        if ($request->is('api/*')) {
            $validator = Validator::make($request->all(), [
                'name'=>'required|string',
                'email' => 'required|email:rfc,dns|unique:users,email,'. $user->id.',id',
                'password' => 'required|string|min:8',
                'mobile'=>' required|digits:10|unique:employees,mobile,'. $id.',id',
                'dob'=>'required|date_format:Y-m-d',
                'designation'=>'required|string',
                'doj'=>'required|date_format:Y-m-d',
              ]);
      
              if ($validator->fails()) {
                  return response()->json([
                    'errors' => $validator->errors(),
                    'status' => Response::HTTP_BAD_REQUEST,
                  ], Response::HTTP_BAD_REQUEST);
              }
        } else {
        $request->validate([
            'name'=>'required|string',
            'email' => 'required|email:rfc,dns|unique:users,email,'. $user->id.',id',
            'password' => 'required|string|min:8',
            'mobile'=>' required|digits:10|unique:employees,mobile,'. $id.',id',
            'dob'=>'required|date_format:Y-m-d',
            'designation'=>'required|string',
            'doj'=>'required|date_format:Y-m-d',
            // 'profile_picture' => 'nullable|mimes:jpeg,bmp,png,jpg|max:2048',
        ]);
    }
        // $tempFile = File::files(public_path().'/temp')[0];

        // $tempFileName = $tempFile->getFilename();
        // File::move(public_path(). '/temp'. '/' . $tempFileName, public_path(). '/uploads'. '/' . $tempFileName);
        
        $input = $request->all();
        // $destination = 'uploads/'.$employee->profile_picture;
        // if(File::exists($destination))
        // {
        //     File::delete($destination);
        // }

        // $input['profile_picture'] =  $tempFileName;

        $user->update([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
        ]);
 
        $employee->update([
            'mobile' => $input['mobile'],
            'dob' => $input['dob'],
            'designation' => $input['designation'],
            'doj' => $input['doj'],
            'user_id' => $user->id,       
         ]);
         $employee->user;

        if ($request->is('api/*')) {
            return new EmployeeResource($employee);
        }
       else
        return redirect('employee')->with('flash_message', 'employee Updated!');  
    }

    public function document_upload(Request $request) 
    {
        if($request->hasFile('file')){
            $file = $request->file('file');
            $completeFileName = time().'_'. $file->getClientOriginalName();
            $request->file('file')->move('temp', $completeFileName);
            return $completeFileName;
        }
    }

    public function remove_tempfile(Request $request) 
    {
        if ($request->has('uploadedfilename')) {
        File::delete('temp/'.$request->uploadedfilename);
        }
        // File::deleteDirectory(public_path('temp'));
    }

    public function destroy(Request $request, $id)
    {
        $isDeleted = Employee::destroy($id);
        // $employee = Employee::findOrFail($id);
        // Employee::where('id', $id)->withTrashed()->forceDelete();
        if ($request->is('api/*')) {
        if ($isDeleted ) {
            return response()->json('Employee deleted successfully');
        }
            // return new EmployeeResource($employee);
        }
       else
        return redirect('employee')->with('flash_message', 'employee deleted!');  
    }

//     public function restore($id) 
//   {
//         Employee::where('id', $id)->withTrashed()->restore();

//         return redirect('employee') ->withSuccess(__('User restored successfully.'));
//   }
}