<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cookie;

use App\Req;
use App\User;
use App\Price;
use App\Slider;
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

class SliderController extends Controller
{

    public function index(){
        return view('admin.slider.sliderEntry');
    }

    public function save(Request $request){
        $wallEntry = new Slider();
        
      

        $wallEntry -> image = 'image';

        $wallEntry -> save();
 
        $lastId=$wallEntry->id;
 
        $pictureInfo=$request->file('image');
          
        $picName = $lastId.$pictureInfo->getClientOriginalName();
        
        $folder="sliderImage/";
 
        $pictureInfo->move($folder,$picName);
 
        $picUrl=$folder.$picName;
 
        $wallPic = Slider::find($lastId);
 
        $wallPic->image = $picUrl;
        $wallPic-> save();
 
       return redirect('/slider/manage')->with('message','Амжилттай');
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
        $user = Slider::all();
        return view('admin.slider.sliderManage', ['user'=>$user]);
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

 

    public function delete($id){
        $loanDelete = Slider::find($id);
        $loanDelete->delete();

        return redirect('/slider/manage')->with('message','deleted');
    }

   

}
