<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
{
    public function survey(Request $request)
    {
       $validator = Validator::make($request->all(), [
        'coordinator_name' => 'required',
        // 'name' => 'required|unique:surveys,name',
        'name' => 'required',
        'age' => 'required',
        'gender' => 'required',
      ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 403);
        }
      
     if($request->coordinator_name != null){
        $coordinatordata = User::where('user_type','=','coordinator')->where('name','=',$request->coordinator_name)->first();
        if($coordinatordata != null){
            $user = new Survey;
            $user->name =  $request->name;
            $user->gender =  $request->gender;
            $user->age =  $request->age;
            $user->user_id  =  $request->share_survey_to_user_id;
            $user->coordinator_id = $coordinatordata->id;
            $user->save();

            $massage = 'Successfully Create Survey';
        
         return response()->json(['message'=>$massage,'statuscode'=>'200','success'=>'true'], 200);
        }else{
            return response()->json(['errors' =>'Please fill valid coordinator name'], 403);
        }
      }
    }

    public function edit_survey(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coordinator_id' => 'required',
            'survey_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 403);
        }

        $checkExitUserid = User::where('user_type','=','coordinator')->where('id','=',$request->coordinator_id)->count();
        if($checkExitUserid > 0){
            $surveydata = Survey::where('id','=',$request->survey_id)->first();
            if($surveydata !=null){
                $user = Survey::find($request->survey_id);
                $user->name = ($request->name == null)? $surveydata->name : $request->name;
                $user->gender = ($request->gender == null)? $surveydata->gender : $request->gender;
                $user->age = ($request->age == null)? $surveydata->age : $request->age;
                $user->user_id  = ($request->share_survey_to_user_id == null)? $surveydata->user_id : $request->share_survey_to_user_id;
                $user->save();
                return response()->json(['message'=>'Successfully survey update','statuscode'=>'200','success'=>'true','data'=>$user], 200);
            }else{
                return response()->json(['errors' =>'Please fill valid survey id'], 403);
            }
           
         }else{
            return response()->json(['message'=>'Please fill valid coordinator id!','statuscode'=>'404','success'=>'false'], 404);
        }
    }

    public function respondent_survey_list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'respondent_type_user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 403);
        }

        $checkExitUserid = User::where('user_type','=','respondent')->where('id','=',$request->respondent_type_user_id)->count();
        if($checkExitUserid > 0){
            $surveydata = Survey::where('user_id','=',$request->respondent_type_user_id)->first();
            if($surveydata !=null){
                $user = Survey::where('user_id','=',$request->respondent_type_user_id)->get();
                return response()->json(['message'=>'Successfully show respondent survey','statuscode'=>'200','success'=>'true','data'=>$user], 200);
            }else{
                return response()->json(['errors' =>'Please fill valid survey id'], 403);
            }
           
         }else{
            return response()->json(['message'=>'Please fill valid coordinator id!','statuscode'=>'404','success'=>'false'], 404);
        }
    }
}
