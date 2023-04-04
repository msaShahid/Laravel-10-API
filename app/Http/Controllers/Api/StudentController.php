<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Else_;

class StudentController extends Controller
{

    public $id;

    // Get
    public function index(){
       
        $student = Student::all();

        if($student->count() > 0){
            return response()->json([
                'Status' => 200,
                'Student' => $student
            ], 200);

        }else{
            return response()->json([
                'Status' => 404,
                'Message' => 'No Recored Found'
            ], 404);

        }
       
    }

    // Create
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ],
        // Custom Validation Message
        [
            'name' => 'Required name field',
            'course' => 'Required course field',
            'email' => 'Required email field',
            'phone' => 'Required phone field',
        ]
    );
        if($validator->fails()){
            // Validation Check
            return response()->json([
                'status' => 404,
                'errors' => $validator->messages()
            ], 404);
        }else{
            // Check Database if recored has or not
            $studentExits = Student::where('email', $request->email)->first();

            if($studentExits){
                return response()->json([
                    'status' => 403,
                    'message' => 'Student recored is already exists!'
                ]);
            }else{
                // If recored is not in Database then insert recored in Database
                $student = Student::create([
                    'name' => $request->name,
                    'course' => $request->course,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);
    
                if($student){
                    return response()->json([
                        'status' => 200,
                        'message' => 'Student Create Successfully !'
                    ], 200);
    
                }else{
                    return response()->json([
                        'status' => 500,
                        'message' => 'Something Went wrong !'
                    ], 500);
                }

            }

        }
    }

    // Show
    public function show(Request $request, $id){
        
        $student = Student::find($id);

        if($student){
            return response()->json([
                'status' => 200,
                'student' => $student
            ], 200);

        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No Recored Found'
            ], 404);
        }
    }


    // edit
    public function edit(Request $request, $id){
        $student = Student::find($id);

        if($student){
            return response()->json([
                'status' => 200,
                'student' => $student
            ], 200);

        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No Recored Found'
            ], 404);
        }
    } 

    //update
    public function update(Request $request, int $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ],
        // Custom Validation Message
        [
            'name' => 'Required name field',
            'course' => 'Required course field',
            'email' => 'Required email field',
            'phone' => 'Required phone field',
        ]
    );
        if($validator->fails()){
            return response()->json([
                'status' => 404,
                'errors' => $validator->messages()
            ], 404);
        }else{
            $student = Student::find($id);
            $student->update([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            if($student){
                return response()->json([
                    'status' => 200,
                    'message' => 'Student Update Successfully!'
                ], 200);

            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'No Such Student Found!'
                ], 404);
            }
           
        }
    }

    public function destory(Request $request, $id){

        $student = Student::find($id);
        if($student){

            $student->delete();
            
            return response()->json([
                'status' => 200,
                'message' => 'Student Delete Successfully!'
            ], 200);

        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No Such Student Found!'
            ], 404);
        }
    }

// end Controller  
}
