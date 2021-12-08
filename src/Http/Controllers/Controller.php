<?php

namespace DevSobSud\MenuManager\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getCollection($sql)
    {
        $draw = request()->get('draw');
        $start = request()->get("start");
        $rowperpage = request()->get("length"); // Rows display per page

        $columnIndex_arr = request()->get('order');
        $columnName_arr = request()->get('columns');
        $order_arr = request()->get('order');
        $search_arr = request()->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['name']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = $sql->count();
        $searchable = $this->getSearchableFields($columnName_arr);
        if($searchValue && $searchable)
        {
            $sql = $sql->where(function($query) use($searchable, $searchValue){
                foreach ($searchable as $key => $value) {
                    if($key == 0)
                        $query->where($value, 'like', '%' .$searchValue . '%');
                    else
                        $query->orWhere($value, 'like', '%' .$searchValue . '%');
                }
            });
        }
        $totalRecordswithFilter = $sql->count();

        // Fetch records
        $records = $sql->orderBy($columnName,$columnSortOrder)
           ->skip($start)
           ->take($rowperpage)
           ->get()->toArray();

        $records = $this->setDTData($records);

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $records
        );

        return response()->json($response);
    }

    abstract protected function setDTData($records);

    protected function getSearchableFields($columns)
    {
        $searchable = [];
        if($columns)
            foreach ($columns as $key => $value) {
                if($value['searchable'] === 'true')
                {
                    $searchable[] = $value['name'];
                }
            }
        return $searchable;
    }
}