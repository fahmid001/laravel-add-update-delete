<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Model\ActivityLogModel;
use App\Model\AccountModel;
use App\Model\BranchModel;
use App\Http\Requests;
use Session;
use Redirect;
use Crypt;
use Hash;
use DB;

class BranchController extends Controller {

    public function __construct() {
        $branchInfo = new BranchModel();
        $logInfo = new ActivityLogModel();
        if (!Session::get('ip_address') == $_SERVER['SERVER_ADDR']):
            Redirect('admin/logout')->send();
        endif;
    }

    public function index() {
        $data['branchInfo'] = DB::table('branch_tbl')->where('isDeleted', '=', '0')->orderBy('id', 'desc')->get();
        $data['active_menu'] = 'branch';
        $data['active_sub_menu'] = 'branch-list';
        return view('controlpanel.branch.branch', $data);
    }

    public function details($id) {
        try {
            $data['active_menu'] = 'branch';
            $data['active_sub_menu'] = 'branch-list';
            $id = Crypt::decrypt($id);
            $data['branchInfo'] = DB::table('branch_tbl')->where('id', '=', $id)->get();
            return view('controlpanel.branch.view-branch', $data);
        } catch (DecryptException $e) {
            return response(view('errors.404'), 404);
        }
    }

    public function add() {
        $data['active_menu'] = 'branch';
        $data['active_sub_menu'] = 'add-branch';
        $data['divisionList'] = DB::table('division_tbl')->get();
        $bra_codeQry = DB::table('branch_tbl')->orderBy('id', 'desc')->take(1)->get();
        $bra_code = $bra_codeQry[0]->bra_code;
        if ($bra_code):
            $data['branch_code'] = $bra_code + 1;
        else:
            $data['branch_code'] = '1001';
        endif;
        return view('controlpanel.branch.add-branch', $data);
    }

    public function store(Request $request) {
        $rules = array(
            'branch_name' => 'required',
            'branch_code' => 'required',
            'branch_type' => 'required',
            'division' => 'required',
            'district' => 'required',
            'upazila' => 'required',
            'branch_address' => 'required',
            'phone' => 'required',
            'latlon' => 'required',
            'opening_date' => 'required',
            'locations' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            #Session::flash('error_message', ' One or more mandatory fields are empty !!!');
            return Redirect::to('add-branch')->withInput()->withErrors($validator, 'branch'); // send back all errors to the login form   
        } else {
            $branchInfo = new BranchModel();
            $count = BranchModel::where('bra_name', '=', $request->input('branch_name'))
                    ->where('bra_code', '=', $request->input('branch_code'))
                    ->count(); //if the same branch_name and branch_code are same show the error message
            if ($count > 0):
                Session::flash('error_message', ' This Branch is Already Exist !!!');
                return Redirect::to('add-branch')->withInput();
            endif;
            $branchInfo->bra_name = $request->input('branch_name');
            $branchInfo->bra_code = $request->input('branch_code');
            $branchInfo->bra_type = $request->input('branch_type');
            $branchInfo->bra_division_id = $request->input('division');
            $branchInfo->bra_district_id = $request->input('district');
            $branchInfo->bra_upazila_id = $request->input('upazila');
            $branchInfo->bra_address = $request->input('branch_address');
            $branchInfo->bra_phone = $request->input('phone');
            $branchInfo->bra_fax = $request->input('fax');
            $branchInfo->bra_latlon = $request->input('latlon');
            $var = $request->input('opening_date');
            $date = str_replace('/', '-', $var);
            $branchInfo->bra_openingdate = date('Y-m-d', strtotime($date));

            $SaveData = $branchInfo->save();

            if ($SaveData) {
                Session::flash('success_message', ' New ' . $request->input('branch_name') . ' Branch Created Successfully !!!');
                $this->activityLog("ADD", $request->input('branch_name') . ' - Branch Created.');
                return Redirect::to('branch');
            } else {
                Session::flash('error_message', ' Failed To Create New Branch !!!');
                return Redirect::to('branch');
            }
        }
    }

    public function destroy($id) {
        try {
            $id = Crypt::decrypt($id);
            $count1 = AccountModel::where('acc_branch_id', '=', $id)->count();
            $count2 = DB::table('users_tbl')->where('user_branch_id', '=', $id)->count();
            $count3 = DB::table('othersinfo_tbl')->where('oth_agentbranch_no', '=', $id)->count();
            if ($count1 > 0 || $count2 > 0 || $count3 > 0):
                Session::flash('error_message', ' Failed to delete. It is being used by other one !!!');
                return Redirect::to('branch');
            endif;
            $branchInfo = BranchModel::find($id);
            $branchName = $branchInfo->bra_name;
            $branchInfo->isDeleted = 1;
            $DeleteData = $branchInfo->save();
            if ($DeleteData) {
                #save Activity Log for this action
                $this->activityLog("DELETE", $branchName . " - Branch Deleted.");
                Session::flash('success_message', ' Successfully Branch Information Delete !!!');
            } else {
                Session::flash('error_message', ' Failed To Delete Branch Information !!!');
            }return Redirect::to('branch');
        } catch (DecryptException $e) {
            return response(view('errors.404'), 404);
        }
    }

    public function edit($id) {
        try {
            $data['active_menu'] = 'branch';
            $data['active_sub_menu'] = 'branch-list';
            $id = Crypt::decrypt($id);
            $data['divisionList'] = DB::table('division_tbl')->get();
            $data['branchInfo'] = DB::table('branch_tbl')->where('id', '=', $id)->get();
            $divisionId = $data['branchInfo'][0]->bra_division_id;
            $districtId = $data['branchInfo'][0]->bra_district_id;
            $data['districtList'] = DB::table('district_tbl')->where('dis_division_id', '=', $divisionId)->get();
            $data['upazilaList'] = DB::table('upazila_tbl')->where('upa_district_id', '=', $districtId)->get();
            return view('controlpanel.branch.edit-branch', $data);
        } catch (DecryptException $e) {
            return response(view('errors.404'), 404);
        }
    }

    public function update(Request $request) {
        try {
            $branchId = Crypt::decrypt($request->input('id'));
            $rules = array(
                'branch_name' => 'Required',
                'branch_type' => 'required',
                'division' => 'required',
                'district' => 'required',
                'upazila' => 'required',
                'branch_address' => 'required',
                'phone' => 'required',
                'latlon' => 'required',
                'opening_date' => 'required',
                'locations' => 'required'
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                #Session::flash('error_message', ' One or more mandatory fields are empty !!!');
                return Redirect::to('edit-branch/' . Crypt::encrypt($branchId))->withErrors($validator, 'branch');
                ;
            } else {
                $count = BranchModel::where('id', '!=', $branchId)
                        ->where('bra_name', '=', $request->input('branch_name'))
                        ->where('bra_code', '=', $request->input('branch_code'))
                        ->where('isDeleted', '=', 0)
                        ->count();
                if ($count > 0) :
                    Session::flash('error_message', ' This Branch is Already Exist !!!');
                    return Redirect::to('edit-branch/' . Crypt::encrypt($branchId));
                endif;
                $branchInfo = BranchModel::find($branchId);
                $branchInfo->bra_name = $request->input('branch_name');
                $branchInfo->bra_type = $request->input('branch_type');
                $branchInfo->bra_division_id = $request->input('division');
                $branchInfo->bra_district_id = $request->input('district');
                $branchInfo->bra_upazila_id = $request->input('upazila');
                $branchInfo->bra_address = $request->input('branch_address');
                $branchInfo->bra_phone = $request->input('phone');
                $branchInfo->bra_fax = $request->input('fax');
                $branchInfo->bra_latlon = $request->input('latlon');
                $var = $request->input('opening_date');
                $date = str_replace('/', '-', $var);
                $branchInfo->bra_openingdate = date('Y-m-d', strtotime($date));

                $updateData = $branchInfo->save();

                if ($updateData) {
                    //save Activity Log for this action
                    $this->activityLog("EDIT", $request->input('branch_name') . " - branch updated.");
                    Session::flash('success_message', ' Successfully Branch Information Update !!!');
                    return Redirect::to('branch');
                } else {
                    Session::flash('error_message', ' Failed to update branch information !!!');
                    return Redirect::to('edit-branch/' . Crypt::encrypt($branchId));
                }
            }
        } catch (DecryptException $e) {
            return response(view('errors.404'), 404);
        }
    }

    public function getdistrictList(Request $request) {
        $division_id = $request->input('value');
        if (is_int((int) $division_id)):
            $divisionQry = DB::table('district_tbl')->where('dis_division_id', '=', $division_id)->get();
            if ($divisionQry):
                echo '<option value="">Select District</option>';
                foreach ($divisionQry as $value):
                    $id = $value->id;
                    $name = $value->dis_name;
                    echo '<option value=' . $id . '>' . $name . '</option>';
                endforeach;
            else :
                echo '<option value = "">no data found</option>';
            endif;
        else:
            echo '<option value = "">no data found</option>';
        endif;
    }

    public function getupazilaList(Request $request) {
        $district_id = $request->input('value');
        if (is_int((int) $district_id)):
            $districtQry = DB::table('upazila_tbl')->where('upa_district_id', '=', $district_id)->get();
            if ($districtQry):
                echo '<option value="">Select Upazila</option>';
                foreach ($districtQry as $value):
                    $id = $value->id;
                    $name = $value->upa_name;
                    echo '<option value=' . $id . '>' . $name . '</option>';
                endforeach;
            else :
                echo '<option value = "">no data found</option>';
            endif;
        else:
            echo '<option value = "">no data found</option>';
        endif;
    }

    public function activityLog($act_type, $message) {
        $logInfo = new ActivityLogModel();
        $act_people_type = Session::get('admin_login_type');
        $logInfo->act_people_type = $act_people_type;
        if ($act_people_type == 1 || $act_people_type == 2):
            $logInfo->act_people_id = Session::get('admin_login_id');
        else:
            $logInfo->act_people_id = Session::get('people_login_id');
        endif;
        $logInfo->act_ip_address = $_SERVER['SERVER_ADDR'];
        $logInfo->act_operation = $message;
        $logInfo->act_operation_type = $act_type;
        $logInfo->act_operation_date = date("Y-m-d");
        $logInfo->act_operation_time = date("H:i:s");
        $logInfo->act_status = 1;
        $SaveData = $logInfo->save();
    }

}
