<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;

class AccountController extends Controller
{
    public function index(){
        $AccountEntry = new Account();
        return view('admin.account.accountEntry');
    }
    

    public function save(Request $request){
        $AccountEntry = new Account();
        $AccountEntry -> cif = $request ->cif; 
       $AccountEntry -> accountname = $request ->accountname; 
       $lastId=$AccountEntry->orderBy('id', 'DESC')->pluck('id')->first();
       $AccountEntry -> account = (int)$lastId + 100000001;
       $AccountEntry -> type = $request ->type;
       $AccountEntry -> interest = $request ->interest;
       $AccountEntry -> status = $request ->status;
       $AccountEntry -> save();
        
       return redirect('/account/save')->with('message','Амжилттай');
    }
    public function manage(){
        $account = Account::all();
        return view('admin.account.accountManage', ['account'=>$account]);
    }

    public function edit($id){

        $accountEdit = Account::where('id', $id)->first();
        return view('admin.account.accountEdit', ['account'=>$accountEdit]);

    }

    public function update(Request $request){
       $account= Account::find($request->accountId);
       $account -> name = $request ->name; 
       $account -> job = $request ->job;
       $account -> phone = $request ->phone;
       $account -> email = $request ->email;
       $account -> facebook = $request ->facebook;
       $account -> twitter = $request ->twitter;
       
       
       $snz -> save();

       

       return redirect('/account/manage')->with('message','updated');
    }

    public function delete($id){
        $accountDelete = Account::find($id);
        $accountDelete->delete();

        return redirect('/account/manage')->with('message','deleted');
    }
      
}
