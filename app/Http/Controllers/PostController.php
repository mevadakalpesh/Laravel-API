<?php

namespace App\Http\Controllers;

use App\Models\post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    
 
    
    function posts(){
       
    return post::all();
    }
    
    function add_post(Request $request){
    
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status_code' => 400 , 'message' => 'Bad Request']);
        }
        $post = new post;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();
        
        return response()->json(['status_code' => 200 , 'message' => 'Post Add Succesfully']);


       }
       
       function remove_post($id){
           post::find($id)->delete();
        return response()->json(['status_code' => 200 , 'message' => 'Post deleted Succesfully']);
       }


       function updated_post(Request $request,$id){
         $post = post::find($id);
         $post->title = $request->title;
         $post->content = $request->content;
         $post->save();
         return response()->json(['status_code' => 200 , 'message' => 'Post upadted Add Succesfully']);
       }

       function user_register(Request $request){
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:Users',
            'password' => 'required|confirmed',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status_code' => 400 , 'message' => 'Bad Request']);
        }
        
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['status_code' => 200 , 'message' => 'Register Sucessfully']);
       }

        
        function user_login(Request $request){

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|',
                'password' => 'required',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['status_code' => 400 , 'message' => 'Bad Request']);
            }
          
          if(!Auth::attempt(['email' => $request->email , 'password' => $request->password])){
            return response()->json(['status_code' => 400 , 'message' => 'cradiantial not much']);
          }
          
          $user_name  = User::where('email',$request->email)->first();
        $user_token =   $user_name->createToken('authToken')->plainTextToken;

          return response()->json(['status_code' => 200 , 'message' => $user_token]);
        
        }
}
