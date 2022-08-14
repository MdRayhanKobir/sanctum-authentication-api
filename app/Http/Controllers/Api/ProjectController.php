<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //create project api
    public function create(Request $request){
         // validation
         $request->validate([
            'name' => 'required',
            'description' => 'required',
            'duration' => 'required',
        ]);

        // student_id + create data
        $studentid=auth()->user()->id;
         $data=new Project();
         $data->student_id=$studentid;
         $data->name=$request->name;
         $data->description=$request->description;
         $data->duration=$request->duration;
         $data->save();

        //  send response
        return response()->json([
            'status'=>1,
            'message'=>'successfully project created'
        ],200);

    }

    // list project api
    public function listproject(){

        $student_id=auth()->user()->id;
        $data=Project::where('student_id',$student_id)->get();

        // send response
        return response()->json([
            'status'=>1,
            'message'=>'projects',
            'data'=>$data
        ],200);

    }

    // single project api
    public function singleproject($id){

        $student_id=auth()->user()->id;

        if(Project::where([
            'id'=>$id,
            'student_id'=>$student_id
        ])->exists()){

            $data=Project::find($id);
            return response()->json([
                'status'=>1,
                'message'=>'project details',
                'data'=>$data
            ],200);


        }else{
            return response()->json([
                'status'=>0,
                'message'=>'project not found',

            ],404);

        }

    }

    // update project api
    public function update(Request $request){

    }

    // delete project api
    public function delete($id){

        $student_id=auth()->user()->id;

        if(Project::where([
            'id'=>$id,
            'student_id'=>$student_id
        ])->exists()){

            $data=Project::where([
                'id'=>$id,
                'student_id'=>$id
            ])->first();

            $data->delete();


            return response()->json([
                'status'=>1,
                'message'=>'project delete success',

            ],200);


        }else{
            return response()->json([
                'status'=>0,
                'message'=>'project delete failed',

            ],404);


        }

    }
}
