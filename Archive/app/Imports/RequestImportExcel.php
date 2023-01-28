<?php
  
namespace App\Imports;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;
use App\Models\Marks;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithLimit;
use Illuminate\Support\Facades\Auth;
class RequestImportExcel implements ToCollection, WithStartRow,WithMultipleSheets, WithValidation, WithLimit
{
    
    /**
    * @return int
    */
    public function startRow(): int
    {
        return 1;
    }
    public function limit(): int
    {
        return 348;
    }
    public function startCell(): string
    {
        return 'A1';
    }


    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            'Sheet1' => $this,
        ];
    }

    public function rules(): array
    {
        return [];
    }

    
    public function collection(Collection $rows)
    {

        // user validation 
        // foreach ($rows as $key=>$row) {
        //     $user = DB::table('users')
        //     ->where('username', '=', $row[0])
        //     ->get();
            
        //     if($key >= 1 && empty($user[0])){
        //         return back()->with('error', 'User not valid'); 
        //     }
        // }
        foreach ($rows as $key=>$row) {
            $missing_column = array();
         
            if($key>=1){    
               
                if(Auth::user()->role!='Customer'){
                    $data=$row[0];
                }
                else {
                    $data=Auth::user()->username;
                } 
                
            
                $data_array = [
                    'phone'=> $row[1],
                    'name'=> $row[3],
                    'amount'=> $row[2],
                    'fb'=> $row[4],
                    'last_action'=> $row[5],
                    'next_action'=> $row[6],
                    'prob'=> '0',
                    'score'=> NULL,
                    'fb_url'=> $row[9],
                    'staff' =>   'Emma',               
                    'created_at' => Carbon::now(),                    

                ];
                DB::table('leads')->insert($data_array);
            

                
            }   
        }
        return back()->with('success', 'Total data imported successfully.');   
    }

}