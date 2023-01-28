<?php

namespace App\Http\Controllers;

use App\Credit;
use App\Mobicom;
use App\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobicomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function import(Request $request)
    {
        $title = "Import Spreadsheet";
        $template = url('documents/template-users.xlsx');
        if ($_POST) {

            $request->validate([
                'file1' => 'required|mimes:xlsx|max:10000'
            ]);

            $file = $request->file('file1');

            $name = time() . '.xlsx';
            $path = public_path('documents' . DIRECTORY_SEPARATOR);
//            print_r($path);
//            return;
            if ($file->move($path, $name)) {
                $inputFileName = $path . $name;
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $reader->setReadDataOnly(true);
                $reader->setLoadSheetsOnly(["Worksheet"]);
                $spreadSheet = $reader->load($inputFileName);
                $workSheet = $spreadSheet->getActiveSheet();
                $startRow = 11;
                $max = 5000;
                $columns = [
                    "A" => "contract_number",
                    "B" => "tran_date",
                    "F" => "desc"
                ];
                $data_insert = [];
                for ($i = $startRow; $i < $max; $i++) {
                    $contract_number = $workSheet->getCell("A$i")->getValue();
                    if (empty($contract_number)) continue;

                    $data_row = [];
                    foreach ($columns as $col => $field) {
                        $val = $workSheet->getCell("$col$i")->getValue();
                        $data_row[$field] = $val;
                        $data_row['updated_at'] = new \DateTime();
                        $data_row['created_at'] = new \DateTime();
                    }
                    $data_insert[] = $data_row;
                }

//                print_r($data_insert);
//                return;

                \DB::table('mobicoms')->truncate();
                \DB::table('mobicoms')->insert($data_insert);

                return redirect('mobicom/import')->with('success', 'Амжилттай!');
            }
        }


        $datas = Mobicom::select("*")->orderBy("created_at", "asc")->get();

        return view('admin.loan.import', compact("title", "template", "datas"));
    }


    function sendsms(Request $request)
    {
        $user = Auth::user();
        $cbdatas = $request->input('cbdatas');
        $smsdata = $request->input('sms');

        $credits = Credit::select("*")
            ->whereIn("id", $cbdatas)->orderBy("created_at", "desc")
            ->get();
        foreach ($credits as $credit) {
            if ($credit->phone !== null) {
                $sms = new Sms();
//                $sms->number = $credit->phone;
                $sms->number = '88109321';
                $sms->msg = $smsdata;
                $sms->status = '0';
                $sms->type = 'mobicom';
                $sms->user = $user->name;
                $sms->date = date('Y-m-d H:i:s');
                $sms->save();
            }
        }
        $result = array(
            "status" => "200",
            "msg" => "success"
        );
        return response()->json($result);
    }
}
