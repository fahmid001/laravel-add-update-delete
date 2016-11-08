@extends('controlpanel/mainlayout')

@section('content')
 <div class="directions"><section class="content-header">
    <h1>
        Branch Details
    </h1>
</section>
 </div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body"> 
                    <div class="box-header with-border">
                        <h3 class="box-title">Branch Details - {{ $branchInfo[0]->bra_name }}</h3>
                    </div>
                    <div style="margin-top:2%;" class="col-lg-12">
                        <div class="panel panel-info">                                            
                            <div class="panel-body">
                                <div style="background-color: #f2f2f2; padding:1%;" class="col-md-6">Branch Name:</div>
                                <div style="background-color: #f2f2f2; padding:1%;" class="col-md-6">{{ $branchInfo[0]->bra_name }}</div>

                                <div style="padding:1%;" class="col-md-6">Branch Code:</div>
                                <div style="padding:1%;" class="col-md-6">{{ $branchInfo[0]->bra_code }}</div>

                                <div style="background-color: #f2f2f2; padding:1%;" class="col-md-6">Branch Type:</div>
                                <div style="background-color: #f2f2f2; padding:1%;" class="col-md-6">{{$branchInfo[0]->bra_type}}</div>

                                <div style="padding:1%;" class="col-md-6">Division:</div>
                                <?php
                                $divisionName = DB::table('division_tbl')->where('id', '=', $branchInfo[0]->bra_division_id)->get();
                                if ($divisionName) {
                                    $divisionName = $divisionName[0]->div_name;
                                } else {
                                    $divisionName = '';
                                }
                                ?>
                                <div style="padding:1%;" class="col-md-6">{{$divisionName}}</div>

                                <div style="background-color: #f2f2f2; padding:1%;" class="col-md-6">District:</div>
                                <?php
                                $districtName = DB::table('district_tbl')->where('id', '=', $branchInfo[0]->bra_district_id)->get();
                                if ($districtName) {
                                    $districtName = $districtName[0]->dis_name;
                                } else {
                                    $districtName = '';
                                }
                                ?>
                                <div style="background-color: #f2f2f2; padding:1%;" class="col-md-6">{{$districtName}}</div>

                                <div style="padding:1%;" class="col-md-6">Upazila:</div>
                                <?php
                                $upazilaName = DB::table('upazila_tbl')->where('id', '=', $branchInfo[0]->bra_upazila_id)->get();
                                if ($upazilaName) {
                                    $upazilaName = $upazilaName[0]->upa_name;
                                } else {
                                    $upazilaName = '';
                                }
                                ?>
                                <div style="padding:1%;" class="col-md-6">{{$upazilaName}}</div>

                                <div style="background-color: #f2f2f2; padding:1%;" class="col-md-6">Address:</div>
                                <div style="background-color: #f2f2f2; padding:1%;" class="col-md-6">{{$branchInfo[0]->bra_address}}</div>

                                <div style="padding:1%;" class="col-md-6">Branch Phone:</div>
                                <div style="padding:1%;" class="col-md-6">{{$branchInfo[0]-> bra_phone}}</div>

                                <div style="background-color: #f2f2f2; padding:1%;" class="col-md-6">Branch Fax:</div>
                                <div style="background-color: #f2f2f2; padding:1%;" class="col-md-6">
                                    <?php
                                    if ($branchInfo[0]->bra_fax):
                                        echo $branchInfo[0]->bra_fax;
                                    else: 
                                        echo "No data inserted";
                                    endif;
                                    ?>
                                </div>
                                <?php
                                $a = explode('-', $branchInfo[0]->bra_openingdate);
                                $my_new_date = $a[2] . '/' . $a[1] . '/' . $a[0];
                                ?>  
                                <div style="padding:1%;" class="col-md-6">Branch Opening Date:</div>
                                <div style="padding:1%;" class="col-md-6">{{ $my_new_date }}</div>
                            </div> 
                        </div>
                        <div style="text-align:center">
                            <a  href="{{URL::to('branch')}}" class="btn btn-primary" type="button">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>  
@stop