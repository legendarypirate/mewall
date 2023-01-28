<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cookie;

use App\Req;
use App\User;
use App\Log;
use App\Good;
use App\Order;
use App\Wall;
use App\Comment;

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

class WallController extends Controller
{

    public function index(){
        return view('admin.wallpaper.wallEntry');
    }


    public function save(Request $request){
        $wallEntry = new Wall();
        $wallEntry -> desc = $request->desc;
        
      

        $wallEntry -> image = 'image';

        $wallEntry -> save();
 
        $lastId=$wallEntry->id;
 
        $pictureInfo=$request->file('image');
          
        $picName = $lastId.$pictureInfo->getClientOriginalName();
        
        $folder="wallImage/";
 
        $pictureInfo->move($folder,$picName);
 
        $picUrl=$folder.$picName;
 
        $wallPic = Wall::find($lastId);
 
        $wallPic->image = $picUrl;
        $wallPic-> save();
 
       return redirect('/wall/manage')->with('message','Амжилттай');
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
        $user = Wall::all();
        return view('admin.wallpaper.wallManage', ['user'=>$user]);
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

        $loanEdit = Lead::where('id', $id)->first();
        return view('admin.loan.loanEdit', ['loan'=>$loanEdit]);

    }

    public function update(Request $request){

       $lead= Lead::find($request->leadid);
       $lead -> phone = $request->phone;
       $lead -> name = $request->name;
       $lead -> amount = $request ->amount;
       $lead -> fb = $request ->fb;
       $lead -> last_action = $request ->last_action;
       $lead -> next_action = $request ->next_action;
       $lead -> prob = $request ->prob;
       $lead -> score = $request ->score;
       $lead -> fb_url = $request ->fb_url;
       $lead -> email = $request ->email;
       $lead -> note = $request ->note;
       $lead -> save();

       return redirect('/leads/manage')->with('message','updated');
    }

 
    
    public function delete($id){
        $loanDelete = Wall::find($id);
        $loanDelete->delete();

        return redirect('/wall/manage')->with('message','deleted');
    }

    public function loadRequestDataTable(Request $request)
    {
        if ($request->ajax()) {
           
            $ids = $request->get('ids', array());
            $status = $request->get('staff',0);            
            $region = $request->get('bus',0);            
            $driverselected = $request->get('driver',0);  
            $except_status = $request->get('except_status',0);  
            $except_st = $request->get('except_st',0);  
            $except_s = $request->get('except_s',0);  
            $staff = $request->get('driver',0);            

            $except_sta = $request->get('except_sta',0);  
            $except_stat = $request->get('except_stat',0);  
            $offset = $request->get('start', 0);
            $limit = $request->get('length', 10);
            if ($limit < 1 OR $limit > 1) {
                $limit = 100;
            }

            $search = isset($request->get('search')['value'])
                    ? $request->get('search')['value']
                    : null;

            $orderColumnList = [
                'id',
                 'amount',
                 'phone',
                 'note',
                 'created_at',
                 'fb_url',
                 'driverselected',
                 'actions'
            ];

            $orderColumnIndex = isset($request->get('order')[0]['column'])
                                ? $request->get('order')[0]['column']
                                : 0;
            $orderColumnDir = isset($request->get('order')[0]['dir'])
                                ? $request->get('order')[0]['dir']
                                : 'asc';

            $orderColumn = isset($orderColumnList[$orderColumnIndex])
                            ? $orderColumnList[$orderColumnIndex]
                            : 'product_name';

            $Params = [
                'search' => $search,
                'limit' => $limit,
                'offset' => $offset,
                'order_column' => $orderColumn,
                'order_dir' => $orderColumnDir,
                'ids' => $ids,
                'staff' => $staff,
                'region' => $region,
           
            ];

           
            $data = Lead::GetExcelData($Params);
           
            $dataCount = Lead::GetExcelDataCount($Params);
            $table = Datatables::of($data)
                        ->addColumn('checkbox', function ($row) {
                            return '<input type="checkbox" class="checkbox" name="foo" data-id="'.$row->id.'" value="'.$row->id.'">';
                        })
                        ->addColumn('id', function ($row) {
                            return $row->id;                           
                        })
                        ->addColumn('phone', function ($row) {
                            return $row->phone;                            
                        })
                        ->addColumn('amount', function ($row) {
                            return $row->amount;                            
                        })
                        ->addColumn('fb', function ($row) {
                            return $row->fb;                            
                        })
                        ->addColumn('last_action', function ($row) {
                            return $row->last_action;                            
                        })
                        ->addColumn('next_action', function ($row) {
                            return $row->next_action;                            
                        })
                        ->addColumn('prob', function ($row) {
                            return $row->prob;                            
                        })
                        ->addColumn('score', function ($row) {
                            return $row->score;                            
                        })
                        ->addColumn('fb_url', function ($row) {
                            return $row->fb_url;                            
                        })
                        ->addColumn('email', function ($row) {
                            return $row->email;                            
                        })
                        ->addColumn('note', function ($row) {
                            return $row->note;                            
                        })
                     
                
                        ->addColumn('created_at', function ($row) {
                            return $row->created_at;                            
                        })
                        ->addColumn('actions', function ($row) {
                            $actions = '
                            <div class="flex justify-center items-center">
                                <a class="flex items-center text-theme-9" href="'.url('/leads/detail/'.$row->id).'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize-2 w-4 h-4 mr-1"><polyline points="15 3 21 3 21 9"></polyline><polyline points="9 21 3 21 3 15"></polyline><line x1="21" y1="3" x2="14" y2="10"></line><line x1="3" y1="21" x2="10" y2="14"></line></svg>
                                Дэлгэрэнгүй  </a></div><div>
                                <a class="flex items-center text-theme-6"  onclick="return confirmation()" href="'.url('/leads/delete/'.$row->id).'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 w-4 h-4 mr-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                Устгах</a>
                            </div><div>
                            <a class="flex items-center text-theme-1"  href="'.url('/leads/fix/'.$row->id).'">
                            Засах</a>
                        </div>';

                            return $actions;                            
                        })
                       
                        ->rawColumns(['checkbox','actions'])
                        ->skipPaging()
                        ->setTotalRecords($dataCount)
                        ->make(true);

            return $table;
        }
    }

}
