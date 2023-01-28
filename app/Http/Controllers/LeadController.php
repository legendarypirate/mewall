<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cookie;

use App\Req;
use App\User;
use App\Log;
use App\Good;
use App\Order;
use App\Ware;
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

class LeadController extends Controller
{

  

}
