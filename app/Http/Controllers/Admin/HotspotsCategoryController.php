<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Model\Hotspots_Swarmlist;
use App\Http\Model\Hotspots_Swarm;
use App\Http\Model\Hotspots;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HotspotsCategoryController extends CommonController {

    public function index($act) {
        $infos = Hotspots_Swarm::orderBy("swarmId", "ASC")->get();
        $level = $this->fun_level(session('ma_level'));
        return view('admin.hotspots_category', compact('infos', 'level', 'act'));
    }

    public function show_add($act) {
        $level = $this->fun_level(session('ma_level'));
        return view('admin.hotspots_category_add', compact('level', 'act'));
    }

    public function show_update($id, $act) {
        $info = Hotspots_Swarm::where("swarmId", $id)->first();
        $details = Hotspots_Swarmlist::where("swarmId", $id)->get();
        $rids = [];
        foreach ($details as $detail) {
            $rids[] = $detail->rid;
        }
        $hotspots = Hotspots::select("rid", "aliasName")->whereIn("rid", $rids)->get();
        $level = $this->fun_level(session('ma_level'));
        return view('admin.hotspots_category_update', compact('info', 'hotspots', 'level', 'act'));
    }

    public function add(Request $request) {
        $input = $request->all();
        $swarmName = $input["swarmName"];
        $rids = [];
        if (isset($input["rids"])) {
            $rids = $input["rids"];
        }
        try {
            DB::beginTransaction();
            $swarmId = Hotspots_Swarm::insertGetId(["swarmName" => $swarmName]);
            if ($swarmId && !empty($rids)) {
                $data = [];
                foreach ($rids as $rid) {
                    $data[] = ["swarmId" => $swarmId, "rid" => $rid];
                }
                Hotspots_Swarmlist::insert($data);
            }
            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();
            echo 'error';
        }
        return redirect('admin/hotspots_category/4');
    }

    public function update(Request $request, $id) {
        $input = $request->all();
        $swarmName = $input["swarmName"];
        $rids = [];
        if (isset($input["rids"])) {
            $rids = $input["rids"];
        }
        try {
            DB::beginTransaction();
            Hotspots_Swarm::where("swarmId", $id)->update(["swarmName" => $swarmName]);
            if (!empty($rids)) {
                Hotspots_Swarmlist::where("swarmId", $id)->delete();
                $data = [];
                foreach ($rids as $rid) {
                    $data[] = ["swarmId" => $id, "rid" => $rid];
                }
                Hotspots_Swarmlist::insert($data);
            }
            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();
            echo 'error';
        }
        return redirect('admin/hotspots_category/4');
    }

    public function delete(Request $request) {
        $swarmId = $request->input("id");
        try {
            DB::beginTransaction();
            Hotspots_Swarmlist::where("swarmId", $swarmId)->delete();
            Hotspots_Swarm::where("swarmId", $swarmId)->delete();
            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();
            echo 'error';
        }
    }

    public function getHotspotsCount(Request $request) {
        $swarmId = $request->input("id");
        return Hotspots_Swarmlist::where("swarmId", $swarmId)->count();
    }

}
