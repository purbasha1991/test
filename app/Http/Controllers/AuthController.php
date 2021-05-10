<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\User;
use App\Http\Models\Visitor;
use Validator;
use Illuminate\Support\Facades\Hash;
     /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
class AuthController extends Controller
{
    public function register(Request $request)
    {
    
         $validator = \Validator::make($request->all(), [
            
            'name' => 'required', 
            'email' => 'required|email', 
            'phone' => 'required',
            'password' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['msg'=> $validator->errors()->all() ,'status'=> 101 ]);
        } 
        $data = $request;
        
        $userDetail['name'] = $data['name'];
        $userDetail['email'] = $data['email'];
        $userDetail['password'] =md5($data['password']);
        $userDetail['phone'] = $data['phone'];
         
        $userDetail['created_at'] = date('Y-m-d H:i:s'); 
        $result = User::where('email',$data['email'])->first();
            if ($result) 
            {
                return response()->json(['status'=>101,'msg'=>['Already Registered! Please check Email Id!!!']]);
            }
            else
            {
                $save = User::insert($userDetail);      

                return response()->json(['status'=>200,'msg'=>['User registered successfully']]);
            }

        
    }
    
    public function login(Request $request)
    {
          
    $validator = \Validator::make($request->all(), [
          
            'email' => 'required|email', 
            'password' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['msg'=> $validator->errors()->all() ,'status'=> 101 ]);
        } 
       
       
        $credentials = User::where([
                       'email' => $request->input('email'),
                        'password' => md5($request->input('password')),
                ])->first();
        if(empty($credentials)){
            return response()->json(["status" => 101, "error" => "Invalid Credentials"]);
            
        }

        else{
            
            User::where([
                       'email' => $request->input('email'),
                ])->update(['api_key' => Hash::make($request->input('password'))]);
            
             $user=User::select('api_key')->where('email',  $request->input('email'))->get()->toArray();
            
            if(empty($user)){
                return response()->json(["status" => 101,'error'=>'Inactive user credential']);
            }
            else{
                return response()->json(["status" => 200,'msg'=>'Logged in Successfully','data' => $user]);
            }
            
        }
        
    }
    public function profile(Request $request)
    {
          
    $validator = \Validator::make($request->all(), [
          
            'token' => 'required', 
            
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['msg'=> $validator->errors()->all() ,'status'=> 101 ]);
        } 
       
       
        $credentials=User::select('name','email','phone')->where('api_key',  $request->input('token'))->get()->toArray();
        
        if(empty($credentials)){
            return response()->json(["status" => 101, "error" => "Invalid Token Passed!!!"]);
            //return response()->json(['message' => 'Unauthorized'], 401);
        }
        else{
            return response()->json(["status" => 200,'msg'=>'Success','data' => $credentials]);
        }

        
    }
}