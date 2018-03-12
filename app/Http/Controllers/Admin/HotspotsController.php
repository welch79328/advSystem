<?php

namespace App\Http\Controllers\Admin;

use stdClass;
use App\Http\Model\Hotspots;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HotspotsController extends Controller {

    /**
     * @param Request $request
     * @param object $condition 條件
     *  欄位名  ->  值
     * @param object $sort 排序條件
     *  欄位名  ->  ASC || DESC
     */
    public function getArray(Request $request) {
        $input = $request->except("_token");
        $sort = new stdClass();
        $sort->rid = "ASC";
        $query = Hotspots::query();

        if (!empty($input["condition"])) {
            $condition = json_decode($input["condition"]);
            foreach ($condition as $column => $value) {
                $query->where($column, "like", "%$value%");
            }
        }
        if (!empty(($input["sort"]))) {
            $sort = json_decode($input["sort"]);
            foreach ($sort as $column => $sortType) {
                $query->orderBy($column, $sortType);
            }
        }
        return $query->get()->toJson();
    }

}
