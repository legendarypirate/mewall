<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
   
        
    public function register(Request $request){
     
        $user = new User();
        $user->lname=$request->lname;
        $user->fname=$request->fname;
        $user->phone=$request->phone;
        $user->email=$request->email;
   
        $user->save();
            return response()->json([
            'success' => true,
            'message' => 'Амжилттай',
            'data'=>$user
        ], 200);
    }

    public function acc(Request $request){
     
        $user = User::where('email','=',$request->email)->first();
        $user->account=$request->account;
        $user->bank=$request->bank;
        $user->age=$request->age;
        $user->gender=$request->gender;
        $user->save();
            return response()->json([
            'success' => true,
            'message' => 'Амжилттай',
            'data'=>$user
        ], 200);
    }

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('appToken')->accessToken;
           //After successfull authentication, notice how I return json parameters
            return response()->json([
              'success' => true,
              'token' => $success,
              'user' => $user
          ]);
        } else {
       //if authentication is unsuccessfull, notice how I return json parameters
          return response()->json([
            'success' => false,
            'message' => 'Invalid Email or Password',
        ], 401);
        }
    }
    public function createp(Request $request){
     
        $user = User::where('email','=',$request->email)->first();
        $user->password=bcrypt($request->password);
        $user->save();
            return response()->json([
            'success' => true,
            'message' => 'Амжилттай',
            'data'=>$user
        ], 200);
    }
  
    // public function manage(){
    //     $user = User::all();
    //     return view('admin.user.userManage', ['user'=>$user]);
    // }

    // public function edit($id){

    //     $accountEdit = Account::where('id', $id)->first();
    //     return view('admin.account.accountEdit', ['account'=>$accountEdit]);

    // }

    // public function update(Request $request){
    //   $account= Account::find($request->accountId);
    //   $account -> name = $request ->name; 
    //   $account -> job = $request ->job;
    //   $account -> phone = $request ->phone;
    //   $account -> email = $request ->email;
    //   $account -> facebook = $request ->facebook;
    //   $account -> twitter = $request ->twitter;
       
       
    //   $snz -> save();

       

    //   return redirect('/account/manage')->with('message','updated');
    // }

    // public function delete($id){
    //     $accountDelete = Account::find($id);
    //     $accountDelete->delete();

    //     return redirect('/account/manage')->with('message','deleted');
    // }
      
}
