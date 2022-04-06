<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Resources\Project as ProjectResource;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = $request->pageSize;
        if(empty($pageSize)) {
            $pageSize = config('app.global_page_size');
        }
        
        if($request->search){
           return $this->applySearch($request);
    }
    elseif ($request->fromDate && $request->toDate) 
    {
        return $this->fromtoDate($request);
    }

        else {
        $projects = Project:: select('id','name','status','technology','start_date','end_date')->paginate($pageSize);
        if ($request->is('api/*')) {
            return new ProjectResource($projects);
        }
       else
        return view ('project.index')->with('projects', $projects);
    }
}

 public function search(Request $request)
    { 
        if($request->search){
            // dd($request);
            return $this->applySearch($request);
        }
            elseif ($request->fromDate && $request->toDate) {
                return $this->fromtoDate($request);
            }
 }

 public function applySearch($request){
    $request->validate([
        'search'=>'required|string',
    ]);
     if($request->search != null)
     {
        $projects = Project::where('name','like', '%' .$request->search. '%')
                                        ->orWhere('technology','like', '%' .$request->search. '%')
                                        ->paginate(3);
            $projects->appends(['search' => $request->search]);
        
        if(count($projects)>0){
            if ($request->is('api/*')) {
                return new ProjectResource([$projects]);
            }
            else
            return view('project.index',['projects'=>$projects ,'search' =>$request->search ]);
        }
        return back()->with('error','No results Found');
    }
 }

 public function fromtoDate($request)
 {
    $pageSize = $request->pageSize;
    $fromDate = $request->input('fromDate');
    $toDate = $request->input('toDate');

    $projects = Project::where('created_at', '>=', $fromDate)
             ->where('created_at', '<=', $toDate)->paginate($pageSize);

             $projects->appends(['fromDate' => $request->fromDate, 'toDate' => $request->toDate]);
            //  dd($projects);
        
            //  if(count($projects)>0){
              if ($request->is('api/*')) {
                  return new ProjectResource([$projects]);
              }
              else
              return view('project.index',['projects'=>$projects , 'fromDate' =>$request->fromDate, 'toDate' =>$request->toDate ]);
 }

    
    public function create()
    {       
        $employees = Employee::all();
        return view('partials.project_form', ['employees' => $employees]);     
    }
  
    public function store(Request $request)
    {
        if ($request->is('api/*')) {
            $validator = Validator::make($request->all(), [
                'name'=>'required|string|unique:projects,name',
            'description' => 'required|string',
            'status'=>'required',
            'technology'=>' required|string',
            'start_date'=>'required|date|before:end_date',
            'end_date'=>'required|date|after:start_date',
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
            'name'=>'required|string|unique:projects,name',
            'description' => 'required|string',
            'status'=>'required',
            'technology'=>' required|string',
            'start_date'=>'required|date|before:end_date',
            'end_date'=>'required|date|after:start_date',
        ]);
    }
        $input = $request->all();
        $project = Project::create($input);
        if ($input['employee_id'] ?? false) {
            $project->employee()->attach($input['employee_id']);
        }
        if ($input['user_id'] ?? false) {
            $project->user()->attach($input['user_id']);
        }

        $projectEmployees = $project->employee()->with('user')->get();
        $project->projectEmployees = $projectEmployees;

        if ($request->is('api/*')) {
            return new ProjectResource($project);
        }
       else
        return redirect('project')->with('flash_message', 'Project Addedd!');  
    }
    
    public function show(Request $request, $id)
    {
        $project = Project::find($id);
        $projectEmployees = $project->employee()->with('user')->get();
        $project->projectEmployees = $projectEmployees;
        // $projectUsers = $project->user;
        if ($request->is('api/*')) {
            return new ProjectResource(['project' => $project, 'projectEmployees' => $projectEmployees]);
        }
       else
        return view('project.show', ['project' => $project, 'projectEmployees' =>  $project->employee]);
    }
    
    public function edit(Request $request, $id)
    {
        $project = Project::find($id);
        $employees = Employee::all();
        $projectEmployees = $project->employee()->pluck('id')->toArray();
        // $users = User::all();
        // $projectUsers = $project->user()->pluck('id')->toArray();

        return view('partials.project_form', ['project' => $project,  'employees' => $employees, 'projectEmployees' => $projectEmployees ]);
    }
  
    public function update(Request $request, $id)
    {
        if ($request->is('api/*')) {
            $validator = Validator::make($request->all(), [
            'name'=>'required|string|unique:projects,name,'. $id.',id',
             'description' => 'required|string',
            'status'=>'required',
            'technology'=>' required|string',
            'start_date'=>'required|date|before:end_date',
            'end_date'=>'required|date|after:start_date',
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
            'name'=>'required|string|unique:projects,name,'. $id.',id',
            'description' => 'required|string',
            'status'=>'required',
            'technology'=>' required|string',
            'start_date'=>'required|date|before:end_date',
            'end_date'=>'required|date|after:start_date',
        ]);
    }
        $input = $request->all();
        $project = Project::find($id);
        $project->update($input);

        if (array_key_exists("employee_id", $input))
        $project->employee()->sync($input['employee_id']);
        else
        $project->employee()->detach();

        $projectEmployees = $project->employee()->with('user')->get();
        $project->projectEmployees = $projectEmployees;

        if ($request->is('api/*')) {
            return new ProjectResource($project);
        }
       else
        return redirect('project')->with('flash_message', 'project Updated!');  
    }
  
    public function destroy(Request $request, $id)
    {
        $isDeleted = Project::destroy($id);

        if ($request->is('api/*')) {
            if ($isDeleted) {
                return response()->json('Project deleted successfully');
            }
                // return new EmployeeResource($employee);
            }
           else
        return redirect('project')->with('flash_message', 'project deleted!');  
    }
}