<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Loanreq;

class LoanController extends Controller
{

    public function index(){
        $LoanEntry = new Loanreq();
        return view('admin.loan.loanEntry');
    }


    public function save(Request $request){
        $LoanEntry = new Loanreq();

//       $lastId=$LoanEntry->orderBy('id', 'DESC')->pluck('id')->first();
//       $LoanEntry -> loanid = "АБ2810";
//       $LoanEntry -> amount = $request ->amount;
//       $LoanEntry -> interest = $request ->interest;
//       $LoanEntry -> time = $request ->time;
//       $LoanEntry -> begdate = $request ->begdate;
//       $LoanEntry -> enddate = 88119642;

       $LoanEntry -> save();

       return redirect('/loan/save')->with('message','Амжилттай');
    }
    public function manage(){
        $loan = Loanreq::all();
        return view('admin.loan.loanManage', ['loan'=>$loan]);
    }

    public function edit($id){

        $loanEdit = Loanreq::where('id', $id)->first();
        return view('admin.loan.loanEdit', ['loan'=>$loanEdit]);

    }

    public function update(Request $request){

       $loan= Loanreq::find($request->loanId);
       $loan -> status = 2;


       $loan -> save();

       return redirect('/loan/manage')->with('message','updated');
    }

    public function delete($id){
        $loanDelete = Loanreq::find($id);
        $loanDelete->delete();

        return redirect('/loan/manage')->with('message','deleted');
    }

}
