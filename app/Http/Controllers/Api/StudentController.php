<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    //Register api
    public function register(Request $request){

        // validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'password' => 'required|confirmed',
        ]);

        //  create data
        $data=new Student();
        $data->name=$request->name;
        $data->email=$request->email;
        $data->password=Hash::make($request->password);
        $data->phone_no=isset($request->phone_no) ? $request->phone_no:"";
        $data->save();

        // send response
        return response()->json([
            'status'=>1,
            'message'=>'successfully registation'
        ]);



    }

    // login api
    public function login(Request $request){
            // validation
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // check student
            $student=Student::where('email','=',$request->email)->first();
            if(isset($student->id)){
                if(Hash::check($request->password,$student->password)){
                    $token=$student->createToken('auth_token')->plainTextToken;

                    return response()->json([
                        'status'=>1,
                        'message'=>'successfully login',
                        'access_token'=>$token
                    ],200);

                }else{
                    return response()->json([
                        'status'=>0,
                        'message'=>'student not found'
                    ],404);
                }

            }else{
                return response()->json([
                    'status'=>0,
                    'message'=>'student not found'
                ],404);
            }


    }

    // profile api
    public function profile(){

        return response()->json([
            'status'=>1,
            'message'=>'student profile information',
            'data'=>auth()->user()
        ]);

    }

    // logout api
    public function logout(){

        auth()->user()->tokens()->delete();
        return response()->json([
            'status'=>1,
            'message'=>'successfully logout'
        ],200);

    }
}
