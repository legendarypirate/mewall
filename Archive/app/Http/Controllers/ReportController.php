<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Style_Font;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use App\Credit;
use DateTime;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    //gereenii dugaaraar vvssen nehemjlehgvvd report
    public function exportinvoice(Request $request, $number)
    {
        $type = 'xlsx';
        $filterdates = $request['dateeee'];
        $invoice_data = DB::table('invoices')->whereRaw('number = ?', [$number])->orderBy('created_at', 'desc')->get()->toArray();
        $sheet1_array[] = array('Kод', 'Гэрээ Дугаар', 'Зээлдэгч', 'Нэхэмжилсэн дүн', 'Нэхэмжлэгч', 'Нэхэмжилсэн өдөр', 'Хоног', 'Төлсөн эсэх', 'Төлсөн өдөр');
        foreach ($invoice_data as $invoice) {
            $ispayed = 'Төлөгдөөгүй';
            $payeddate = '-';
            if ($invoice->status === '2' || $invoice->status === '3') {
                $ispayed = 'Төлсөн';
                $payeddate = $invoice->transaction_date;
            }

            $code = $invoice->bill_no;
            if (strpos($invoice->bill_no, '-') !== false) {
                $convert = explode('-', $invoice->bill_no);
                if (count($convert) > 1)
                    $code = $convert[1];
            }
            $sheet1_array[] = array(
                $code,
                $invoice->number,
                $invoice->name,
                number_format($invoice->amount, 2),
                $invoice->client,
                $invoice->created_at,
                $invoice->honog,
                $ispayed,
                $payeddate
            );
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Invoices");

        $styleArray = array(
            'font' => array(
                'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
            )
        );
        $rows = 1;
        foreach ($sheet1_array as $sheet1) {
            $sheet->setCellValue('A' . $rows, $sheet1[0]);
            $sheet->setCellValue('B' . $rows, $sheet1[1]);
            $sheet->setCellValue('C' . $rows, $sheet1[2]);
            $sheet->setCellValue('D' . $rows, $sheet1[3]);
            $sheet->setCellValue('E' . $rows, $sheet1[4]);
            $sheet->setCellValue('F' . $rows, $sheet1[5]);
            $sheet->setCellValue('G' . $rows, $sheet1[6]);
            $sheet->setCellValue('H' . $rows, $sheet1[7]);
            $sheet->setCellValue('I' . $rows, $sheet1[8]);

            if ($rows === 1) {
                $sheet->getStyle('A' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('B' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('C' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('D' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('E' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('F' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('G' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('H' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('I' . $rows)->applyFromArray($styleArray);

            }

            $rows++;
        }

        foreach (range('A', 'N') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $fileName = "Invoices-" . $number . "." . $type;
        if ($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if ($type == 'xls') {
            $writer = new Xls($spreadsheet);
        }
        $writer->save("export/" . $fileName);
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/') . "/export/" . $fileName);
    }


    //tologdson nehemjlehvvdiig ono saraar gargah
    public function exportpaidinvoices(Request $request)
    {
        $type = 'xlsx';
        $start_date = '2019-01-01';
        $end_date = '2060-01-01';
        $filterdates = $request['dateeee'];
        if (strpos($filterdates, '-') !== false) {
            $lpos = strpos($filterdates, "-");
            $start_date = substr($filterdates, 0, $lpos);
            $end_date = substr($filterdates, $lpos + 1, strlen($filterdates));
            $start_date = Carbon::parse($start_date)->format('Y-m-d');
            $end_date = Carbon::parse($end_date)->format('Y-m-d');

        }
        $paid_data = DB::table('invoices')->whereRaw('status in (2, 3) and transaction_date >= ? and transaction_date <= ?', [$start_date, $end_date])->orderBy('created_at', 'desc')->get()->toArray();
        $sheet1_array[] = array('Нэхэмжлэх дугаар', 'Нэр', 'Утас', 'Төлсөн дүн', 'Төлсөн өдөр', 'Хоног', 'Төрөл', 'Pro auto', 'Нэхэмжлэгч');
        foreach ($paid_data as $invoice) {

//            $code = $invoice->bill_no;
//            if (strpos($invoice->bill_no, '-') !== false) {
//                $convert = explode('-', $invoice->bill_no);
//                if (count($convert) > 1)
//                    $code = $convert[1];
//            }
            $proauto = "-";
            if ($invoice->status === '3') {
                $proauto = "Бичсэн";
            }
            $sheet1_array[] = array(
                $invoice->bill_no,
                $invoice->name,
                $invoice->phone,
                number_format($invoice->transaction_amount, 2),
                $invoice->transaction_date,
                $invoice->honog,
                $invoice->desc,
                $proauto,
                $invoice->client
            );
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("PAID_Invoices");

        $styleArray = array(
            'font' => array(
                'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
            )
        );
        $rows = 1;
        foreach ($sheet1_array as $sheet1) {
            $sheet->setCellValue('A' . $rows, $sheet1[0]);
            $sheet->setCellValue('B' . $rows, $sheet1[1]);
            $sheet->setCellValue('C' . $rows, $sheet1[2]);
            $sheet->setCellValue('D' . $rows, $sheet1[3]);
            $sheet->setCellValue('E' . $rows, $sheet1[4]);
            $sheet->setCellValue('F' . $rows, $sheet1[5]);
            $sheet->setCellValue('G' . $rows, $sheet1[6]);
            $sheet->setCellValue('H' . $rows, $sheet1[7]);
            $sheet->setCellValue('I' . $rows, $sheet1[8]);

            if ($rows === 1) {
                $sheet->getStyle('A' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('B' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('C' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('D' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('E' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('F' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('G' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('H' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('I' . $rows)->applyFromArray($styleArray);

            }

            $rows++;
        }

        foreach (range('A', 'N') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $fileName = "PaidInvoices" . "." . $type;
        if ($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if ($type == 'xls') {
            $writer = new Xls($spreadsheet);
        }
        $writer->save("export/" . $fileName);
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/') . "/export/" . $fileName);
    }


    public function exportcredits()
    {
        $results = Credit::leftJoin('invoices', 'invoices.credit_id', '=', 'credits.credit_id')
            ->select(
                'credits.*',
                DB::raw('sum(case when invoices.type in ("9","5","2") then 1 else 0 end) as khuusent'),
                DB::raw('sum(case when invoices.status = "1" then 1 else 0 end) as pending'),
                DB::raw('sum(case when (invoices.status = "2" or invoices.status = "3") then 1 else 0 end) as paid'),
                DB::raw('sum(case when (invoices.honog > -1 and invoices.honog < 60) then 1 else 0 end) as honog_first'),
                DB::raw('sum(case when (invoices.honog > 59 and invoices.honog < 90) then 1 else 0 end) as honog_second'),
                DB::raw('sum(case when (invoices.honog > 89) then 1 else 0 end) as honog_last')
            )
            ->groupBy(
                'credits.id',
                'credits.credit_id',
                'credits.number',
                'credits.phone',
                'credits.duusah_honog',
                'credits.lastname',
                'credits.amount',
                'credits.huramtlagdsankhuu',
                'credits.aldangi',
                'credits.khuu',
                'credits.assessment',
                'credits.zeeluldegdel',
                'credits.khetersenkhonog',
                'credits.honog',
                'credits.created_at',
                'credits.updated_at',
                'credits.secondphone',
                'credits.registernumber',
                'credits.firstname',
                'credits.address',
                'credits.paymentdate'
            )
            ->get();


        $type = 'xlsx';

        $sheet1_array[] = array('Гэрээний дугаар', 'Утас', 'Үлдэгдэл', 'Хуримтлагдсан хүү', 'Төлөх дүн', 'Хоног', 'Хүү', '0-59 хоног', '60-89 хоног', '90 дээш');
        foreach ($results as $data) {
            $today = date("Y/m/d");
            $datetime1 = new DateTime($data->duusah_honog);
            $datetime2 = new DateTime($today);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');
            $curhonog = 0;
            if ($data->khetersenkhonog === '0') {
                $curhonog = (30 - ($days));
            } else {
                $curhonog = $data->khetersenkhonog + 30;
            }
            $sheet1_array[] = array(
                $data->number,
                $data->phone,
                number_format(-1 * $data->zeeluldegdel, 2),
                number_format($data->khuu + $data->aldangi, 2),
                number_format($data->amount, 2),
                $curhonog,
                $data->assessment,
                $data->honog_first,
                $data->honog_second,
                $data->honog_last,
            );
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Credits");

        $styleArray = array(
            'font' => array(
                'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
            )
        );
        $rows = 1;
        foreach ($sheet1_array as $sheet1) {
            $sheet->setCellValue('A' . $rows, $sheet1[0]);
            $sheet->setCellValue('B' . $rows, $sheet1[1]);
            $sheet->setCellValue('C' . $rows, $sheet1[2]);
            $sheet->setCellValue('D' . $rows, $sheet1[3]);
            $sheet->setCellValue('E' . $rows, $sheet1[4]);
            $sheet->setCellValue('F' . $rows, $sheet1[5]);
            $sheet->setCellValue('G' . $rows, $sheet1[6]);
            $sheet->setCellValue('H' . $rows, $sheet1[7]);
            $sheet->setCellValue('I' . $rows, $sheet1[8]);
            $sheet->setCellValue('J' . $rows, $sheet1[9]);
            if ($rows === 1) {
                $sheet->getStyle('A' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('B' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('C' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('D' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('E' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('F' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('G' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('H' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('I' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('J' . $rows)->applyFromArray($styleArray);

            }
            $rows++;
        }

        foreach (range('A', 'N') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $fileName = "Credits" . "." . $type;
        if ($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if ($type == 'xls') {
            $writer = new Xls($spreadsheet);
        }
        $writer->save("export/" . $fileName);
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/') . "/export/" . $fileName);

    }


    public function exportcredits2()
    {
        $results = Credit::select('credits.*')
            ->get();

        $type = 'xlsx';
        $sheet1_array[] = array('credit_id', 'number', 'phone', 'secondphone', 'duusah_honog', 'lastname', 'amount',
            'huramtlagdsankhuu', 'aldangi', 'khuu', 'assessment', 'zeeluldegdel', 'khetersenkhonog',
            'honog', 'registernumber', 'firstname', 'address', 'paymentdate');
        foreach ($results as $data) {
            $sheet1_array[] = array(
                $data->credit_id,
                $data->number,
                $data->phone,
                $data->secondphone,
                $data->duusah_honog,
                $data->lastname,
                number_format($data->amount, 2),
                $data->huramtlagdsankhuu,
                $data->aldangi,
                $data->khuu,
                $data->assessment,
                $data->zeeluldegdel,
                $data->khetersenkhonog,
                $data->honog,
                $data->registernumber,
                $data->firstname,
                $data->address,
                $data->paymentdate

            );
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("AllCredits");

        $styleArray = array(
            'font' => array(
                'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
            )
        );
        $rows = 1;
        foreach ($sheet1_array as $sheet1) {
            $sheet->setCellValue('A' . $rows, $sheet1[0]);
            $sheet->setCellValue('B' . $rows, $sheet1[1]);
            $sheet->setCellValue('C' . $rows, $sheet1[2]);
            $sheet->setCellValue('D' . $rows, $sheet1[3]);
            $sheet->setCellValue('E' . $rows, $sheet1[4]);
            $sheet->setCellValue('F' . $rows, $sheet1[5]);
            $sheet->setCellValue('G' . $rows, $sheet1[6]);
            $sheet->setCellValue('H' . $rows, $sheet1[7]);
            $sheet->setCellValue('I' . $rows, $sheet1[8]);
            $sheet->setCellValue('J' . $rows, $sheet1[9]);
            $sheet->setCellValue('K' . $rows, $sheet1[10]);
            $sheet->setCellValue('L' . $rows, $sheet1[11]);
            $sheet->setCellValue('M' . $rows, $sheet1[12]);
            $sheet->setCellValue('N' . $rows, $sheet1[13]);
            $sheet->setCellValue('O' . $rows, $sheet1[14]);
            $sheet->setCellValue('P' . $rows, $sheet1[15]);
            $sheet->setCellValue('Q' . $rows, $sheet1[16]);
            $sheet->setCellValue('R' . $rows, $sheet1[17]);
            if ($rows === 1) {
                $sheet->getStyle('A' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('B' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('C' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('D' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('E' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('F' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('G' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('H' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('I' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('J' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('K' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('L' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('M' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('N' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('O' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('P' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('Q' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('R' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('S' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('T' . $rows)->applyFromArray($styleArray);
            }
            $rows++;
        }

        foreach (range('A', 'T') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $fileName = "AllCredits" . "." . $type;
        if ($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if ($type == 'xls') {
            $writer = new Xls($spreadsheet);
        }
        $writer->save("export/" . $fileName);
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/') . "/export/" . $fileName);

    }


    //sms excel
    public function exportsms(Request $request)
    {
        $type = 'xlsx';
        $start_date = '2019-01-01';
        $end_date = '2060-01-01';
        $filterdates = $request['dateeee'];
        if (strpos($filterdates, '-') !== false) {
            $lpos = strpos($filterdates, "-");
            $start_date = substr($filterdates, 0, $lpos);
            $end_date = substr($filterdates, $lpos + 1, strlen($filterdates));
            $start_date = Carbon::parse($start_date)->format('Y-m-d');
            $end_date = Carbon::parse($end_date)->format('Y-m-d');

        }
        $sms_data = DB::table('sms')->whereRaw('status in (0, 1) and date >= ? and date <= ?', [$start_date, $end_date])->orderBy('id', 'desc')->get()->toArray();
        $sheet1_array[] = array('Утас', 'Мсж', 'Төлөв', 'Илгээсэн өдөр');
        foreach ($sms_data as $sms) {

            $status = "Wait";
            if ($sms->status === '1') {
                $status = "Sent";
            }
            $sheet1_array[] = array(
                $sms->number,
                $sms->msg,
                $status,
                $sms->date,

            );
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Sms");

        $styleArray = array(
            'font' => array(
                'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
            )
        );
        $rows = 1;
        foreach ($sheet1_array as $sheet1) {
            $sheet->setCellValue('A' . $rows, $sheet1[0]);
            $sheet->setCellValue('B' . $rows, $sheet1[1]);
            $sheet->setCellValue('C' . $rows, $sheet1[2]);
            $sheet->setCellValue('D' . $rows, $sheet1[3]);
            if ($rows === 1) {
                $sheet->getStyle('A' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('B' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('C' . $rows)->applyFromArray($styleArray);
                $sheet->getStyle('D' . $rows)->applyFromArray($styleArray);
            }

            $rows++;
        }

        foreach (range('A', 'N') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $fileName = "Sms" . "." . $type;
        if ($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if ($type == 'xls') {
            $writer = new Xls($spreadsheet);
        }
        $writer->save("export/" . $fileName);
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/') . "/export/" . $fileName);
    }


}
