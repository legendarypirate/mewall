<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpMyAdmin\SqlParser\Utils\Table;
use Illuminate\Database\Eloquent\SoftDeletes;
class Lead extends Model
{
    /**
     * Query for `Delivery` data
     *
     * @return mixed
     */
    public static function GetExcelData($Params=null)
    {
        $deliveryTable = (new Lead())->getTable();

        $offset = isset($otherParams['offset']) ? $otherParams['offset'] : 0;
        $limit = isset($Params['limit']) ? $Params['limit'] : 10;

        $idsFilter = NULL;
        $statusFilter = NULL;
        $regionFilter = NULL;
        $driverFilter = NULL;
        $limitFilter = NULL;
   
        $date_filter = NULL;

        
        if (!empty($Params['ids'])) {
            $idsFilter = "AND `id` in ({$Params['ids']})";
        }

        if (!empty($Params['status'])) {
            $statusFilter = "AND `staff`= {$Params['status']}";
        }

        if (!empty($Params['region'])) {
            $regionFilter = "AND region= '{$Params['region']}'";
        }

        if (!empty($Params['driverselected'])) {
            $driverFilter = "AND driverselected= '{$Params['driverselected']}'";
        }

        $orderByFilter = "ORDER BY leads.id DESC ";


        if (!empty($Params['start_date']) && empty($Params['end_date'])) {
            $date_filter = "AND (DATE(created_at) BETWEEN '{$Params['start_date']}' AND '{$Params['start_date']}')";
        }

        if (!empty($Params['start_date']) && !empty($Params['end_date'])) {
            $date_filter = "AND (DATE(created_at) BETWEEN '{$Params['start_date']}' AND '{$Params['end_date']}')";
        }

        

        if ($limit > 0) {
            $limitFilter = "LIMIT {$limit} OFFSET {$offset}";
        }

    

        return DB::select(DB::raw("SELECT *
                    FROM 
                        $deliveryTable                   
                    WHERE 1 = 1
                    {$idsFilter}
                    {$orderByFilter}
                    {$limitFilter}

                "));
    }

    /**
     * Query for `Delivery` data Count
     *
     * @return mixed
     */
    public static function GetExcelDataCount($Params=null)
    {
        $deliveryTable = (new Lead())->getTable();

        $offset = isset($otherParams['offset']) ? $otherParams['offset'] : 0;
        $limit = isset($Params['limit']) ? $Params['limit'] : 10;

        $idsFilter = NULL;
        $statusFilter = NULL;
        $regionFilter = NULL;
        $driverFilter = NULL;
        $limitFilter = NULL;
       
        $date_filter = NULL;

        
        
        if (!empty($Params['ids'])) {
            $idsFilter = "AND `id` in ({$Params['ids']})";
        }

        if (!empty($Params['status'])) {
            $statusFilter = "AND `staff`= {$Params['status']}";
        }

        if (!empty($Params['region'])) {
            $regionFilter = "AND region= '{$Params['region']}'";
        }

        if (!empty($Params['driverselected'])) {
            $driverFilter = "AND driverselected= '{$Params['driverselected']}'";
        }

        $orderByFilter = "ORDER BY leads.id DESC ";


        if (!empty($Params['start_date']) && empty($Params['end_date'])) {
            $date_filter = "AND (DATE(created_at) BETWEEN '{$Params['start_date']}' AND '{$Params['start_date']}')";
        }

        if (!empty($Params['start_date']) && !empty($Params['end_date'])) {
            $date_filter = "AND (DATE(created_at) BETWEEN '{$Params['start_date']}' AND '{$Params['end_date']}')";
        }

        if ($limit > 0) {
            $limitFilter = "LIMIT {$limit} OFFSET {$offset}";
        }

        $resultQuery = DB::select(DB::raw("SELECT COUNT(*) AS total
                    FROM 
                        $deliveryTable                   
                    WHERE 1 = 1
                    {$idsFilter}
                    {$orderByFilter}
                    {$limitFilter}

                "));
        return $resultQuery[0]->total ?? 0;
    }
}
