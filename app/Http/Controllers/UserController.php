<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Price;
use App\Wall;
use App\Lott;
use App\Sett;
use App\Slider;
use App\Quarter;
use App\Lot;

use Auth;
use DB;
use Carbon\Carbon;

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
    
    
      public function updt(Request $request){
     
        $user = User::where('email','=',$request->inf)->first();
        $user->password=bcrypt($request->password);
                $user->fname=$request->fname;
            $user->lname=$request->lname;   
            
            $user->email=$request->email;
        $user->save();
            return response()->json([
            'success' => true,
            'message' => 'Амжилттай',
            'data'=>$user
        ], 200);
    }
    
    
      public function upacc(Request $request){
     
        $user = User::where('email','=',$request->inf)->first();
                $user->bank=$request->bank;
            $user->account=$request->account;   
            
        $user->save();
            return response()->json([
            'success' => true,
            'message' => 'Амжилттай',
            'data'=>$user
        ], 200);
    }
    
     
    
    public function time(Request $request){
     
        $user = User::where('email','=',$request->email)->first();
        $user->runtime=Carbon::now();
        $user->active=1;

        $user->save();
            return response()->json([
            'success' => true,
            'message' => 'Амжилттай',
            'data'=>$user
        ], 200);
    }

    public function stop(Request $request){
        
        $price=Price::All()->first();
        $p=$price->price;
        $user = User::where('email','=',$request->email)->first();
        $user->stoptime=Carbon::now();
        $day=round((strtotime($user->stoptime)-strtotime($user->runtime))/5);
        $user->accum+=$day*$p;
        $user->active=0;
        $user->lifetimeaccum+=$day*$p;
        $user->pricechangeamount+=$user->lifetimeaccum;
        $user->quarterly+=$day;
        $user->lifetime+=$day;

        $user->save();
            return response()->json([
            'success' => true,
            'message' => 'Амжилттай',
            'data'=>$user
        ], 200);
    }

    public function auto(Request $request){
        
        $price=Price::All()->first();
        $p=$price->price;
        $user = User::where('email','=',$request->email)->where('active','1')->first();
        if($user){
        $day=round((strtotime(Carbon::now())-strtotime($user->runtime))/5);
        $user->accum+=$day*$p;
        $user->lifetimeaccum+=$day*$p;
        $user->pricechangeamount+=$user->lifetimeaccum;
        $user->quarterly+=$day;
        $user->lifetime+=$day;
        $user->runtime=Carbon::now();
        $user->save();
        }
            return response()->json([
            'success' => true,
            'message' => 'Амжилттай',
            'data'=>$user
        ], 200);
    }


    public function dayvalue($id){
        
    
        $user = User::where('id',$id)->get();
      
            return response()->json([
            'success' => true,
            'message' => 'Амжилттай',
            'data'=>$user
        ], 200);
    }


    public function lt($id){
        
    
        $data = Lot::where('desct',$id)->get();
      
            return response()->json([
            'success' => true,
            'message' => 'Амжилттай',
            'data'=>$data
        ], 200);
    }

 
    public function image(){
        
    
        $wall =Wall::All();
      
            return response()->json([
            'success' => true,
            'message' => 'Амжилттай',
            'data'=>$wall
        ], 200);
    }
     public function slider(){
        
    
        $wall =Slider::All();
      
            return response()->json([
            'success' => true,
            'message' => 'Амжилттай',
            'data'=>$wall
        ], 200);
    }
      public function sett(){
        
    
        $wall =Sett::All();
      
            return response()->json([
            'success' => true,
            'message' => 'Амжилттай',
            'data'=>$wall
        ], 200);
    }
    
         public function quart(){
        
    
        $wall =Quarter::All();
      
            return response()->json([
            'success' => true,
            'message' => 'Амжилттай',
            'data'=>$wall
        ], 200);
    }



   public function lott(){
        
    
        $ids=Lott::first();
        $id=$ids->id;
        $wall=Lott::where('id',$id)->get();
            return response()->json([
            'success' => true,
            'message' => 'Амжилттай',
            'data'=>$wall
        ], 200);
    }
    
       public function lotts(){
        
    
     
        $wall=Lott::All();
            return response()->json([
            'success' => true,
            'message' => 'Амжилттай',
            'data'=>$wall
        ], 200);
    }

    
    public function manage(){
        $user = User::all();
        return view('admin.user.userManage', ['user'=>$user]);
    }

    public function det($id){

        echo json_encode(DB::table('users')->where('id', $id)->get());

    }


  public function addlot(Request $request){
     
        $lot = new Lot();
        $lot->lot=$request->lot;
        $lot->desct=$request->uid;   
        $lot->save();
        return redirect('/user/manage')->with('message','updated');

    }
    public function update(Request $request){
      $user= User::find($request->uid);
      $user -> lname = $request ->lname; 
      $user -> fname = $request ->fname;
      $user -> bank = $request ->bank;
      $user -> account = $request ->account;
      $user -> email = $request ->email;
       
      $user -> save();

       

      return redirect('/user/manage')->with('message','updated');
    }

    public function delete($id){
        $accountDelete = User::find($id);
        $accountDelete->delete();

        return redirect('/user/manage')->with('message','deleted');
    }
      
}
