<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cookie;

use App\Req;
use App\User;
use App\Price;
use App\Quarter;
use App\Wall;
use App\Comment;
use Carbon\Carbon;

use App\Notif;
use RealRashid\SweetAlert\Facades\Alert;

use Redirect;
use Auth,DB;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReqExport;
use Yajra\DataTables\DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Imports\RequestImportExcel;
use App\Lead;

class QuarterController extends Controller
{

    public function index(){
        return view('admin.quarter.quarterEntry');
    }


    public function save(Request $request){
        $wallEntry = new Quarter();
        $wallEntry -> quart = $request->quart;
              $wallEntry -> sar = $request->sar;

        $wallEntry -> save();
 
       return redirect('/quarter/manage')->with('message','Амжилттай');
    }

    public function excelImport() 
    {
       
        $file = request()->file('file');
        
        if($file){
                Excel::import(new RequestImportExcel,$file); 
                return back();      
                  
        }else{
            return back()->with('error', 'Please Select File');
        }
        
    }

    public function comment(Request $request){
        $LoanEntry = new Comment();
        $LoanEntry -> leadid = $request->leadid;

        $LoanEntry -> comment = $request->comment;
       
        $LoanEntry -> save();
        return Redirect::back();
    }

    public function manage(){
        $user = Quarter::all();
        return view('admin.quarter.quarterManage', ['user'=>$user]);
    }

    public function detail(Request $request, $id)
    {
         
        
        $data = Lead::where('id',$id)->first();
    
        return view( 'admin.lead.detail', compact('data'));
    }
    public function fix($id){

        $loanEdit = Lead::where('id', $id)->first();
        return view('admin.lead.leadEdit', ['lead'=>$loanEdit]);

    }

    public function edit($id){

        $quart = Quarter::where('id', $id)->first();
        return view('admin.quarter.quartEdit', ['quart'=>$quart]);

    }

    public function update(Request $request){

        $quart= Quarter::where('id',$request->qid)->first();
        $quart->quart=$request -> quarter ;
           $quart->sar=$request -> sar ;

        $quart -> save();
       return redirect('/quarter/manage')->with('message','updated');
    }

    public function delete($id){
        $loanDelete = Lead::find($id);
        $loanDelete->delete();

        return redirect('/quarter/manage')->with('message','deleted');
    }

   

}
