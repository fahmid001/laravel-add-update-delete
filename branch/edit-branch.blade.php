@extends('controlpanel/mainlayout')

@section('content')
<div class="directions">
    <section class="content-header">
        <h1>
            Change Branch Information
        </h1>
    </section>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            @if (Session::has('success_message'))
            <div class="alert alert-success alert-dismissable"><i class="fa fa-check"></i><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>{{ Session::get('success_message') }}</div>
            @elseif (Session::has('error_message'))
            <div class="alert alert-danger alert-dismissable"><i class="fa fa-ban"></i><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>{{ Session::get('error_message') }}</div>
            @endif
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Update Branch Data</h3>
                </div>
                <form class="form-horizontal" action="{{URL::to('branch-update')}}" method="post">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="branch_name" class="col-sm-3 control-label">Branch Name<span style="color:red">*</span></label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" id="branch_id" name="id" value="{{ Crypt::encrypt($branchInfo[0]->id) }}">
                                <input type="text" class="form-control" id="branch_name" name="branch_name" value="{{ $branchInfo[0]->bra_name }}" required="required">
                                <span style="color: red"><?php echo $errors->branch->first('branch_name'); ?></span>
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label for="branch_type" class="col-sm-3 control-label">Branch Type<span style="color:red">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="branch_type" id="branch_type" required="required">
                                    <option value="{{ $branchInfo[0]->bra_type }}" selected="selected">{{ $branchInfo[0]->bra_type }}</option>
                                    <option value='Agent'>Agent</option>
                                    <option value='Branch'>Branch</option>
                                    <option value='ATM'>ATM</option>
                                </select>
                                <span style="color: red"><?php echo $errors->branch->first('branch_type'); ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="branch_type" class="col-sm-3 control-label">Select Division<span style="color:red">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="division" id="division" onchange="getdistrictList(this.value)" required="required">
                                    <option value=''>Select Division</option>
                                    @foreach($divisionList as $division)
                                    @if($branchInfo[0]->bra_division_id == $division->id)
                                    <option value="{{$division->id}}" selected="selected" >{{$division->div_name}}</option>
                                    @endif
                                    @if($branchInfo[0]->bra_division_id != $division->id)
                                    <option value="{{$division->id}}">{{$division->div_name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <span style="color: red"><?php echo $errors->branch->first('division'); ?></span>
                            </div>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="branch_type" class="col-sm-3 control-label">Select District<span style="color:red">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control"  name="district" id="district" onchange="getupazilaList(this.value)" required="required">
                                    <option value=''>Select District</option>
                                    @foreach($districtList as $distric)
                                    @if($branchInfo[0]->bra_district_id == $distric->id)
                                    <option value="{{$distric->id}}" selected="selected" >{{$distric->dis_name}}</option>
                                    @endif
                                    @if($branchInfo[0]->bra_district_id != $distric->id)
                                    <option value="{{$distric->id}}">{{$distric->dis_name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <span style="color: red"><?php echo $errors->branch->first('district'); ?></span>
                            </div>
                            <div hidden id="showloging" class="col-sm-1"> <img src="{{URL::to('/')}}/upload/picture/loading.gif" class="img-circle" width="30" height="25"></div>
                        </div>
                        <div class="form-group">
                            <label for="branch_type" class="col-sm-3 control-label">Select Upazila<span style="color:red">*</span></label>
                            <div class="col-sm-6">
                                <select class="form-control"  name="upazila" id="upazila" required="required">
                                    <option value=''>Select Upazila</option>
                                    @foreach($upazilaList as $upazila)
                                    @if($branchInfo[0]->bra_upazila_id == $upazila->id)
                                    <option value="{{$upazila->id}}" selected="selected" >{{$upazila->upa_name}}</option>
                                    @endif
                                    @if($branchInfo[0]->bra_upazila_id != $upazila->id)
                                    <option value="{{$upazila->id}}">{{$upazila->upa_name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <span style="color: red"><?php echo $errors->branch->first('upazila'); ?></span>
                            </div>
                            <div hidden id="showloging2" class="col-sm-1"> <img src="{{URL::to('/')}}/upload/picture/loading.gif" class="img-circle" width="30" height="25"></div>
                        </div>
                        <div class="form-group">
                            <label for="branch_address" class="col-sm-3 control-label">Branch Address<span style="color:red">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="branch_address" name="branch_address" value="{{ $branchInfo[0]->bra_address }}" required="required">
                                <span style="color: red"><?php echo $errors->branch->first('branch_address'); ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-3 control-label">Phone Number<span style="color:red">*</span></label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="phone" name="phone" value="{{ $branchInfo[0]->bra_phone }}" required="required">
                                <span style="color: red"><?php echo $errors->branch->first('phone'); ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fax" class="col-sm-3 control-label">Fax Number</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="fax" name="fax" value="{{ $branchInfo[0]->bra_fax }}">
                            </div>
                        </div>
                        <?php
                        $a = explode('-', $branchInfo[0]->bra_openingdate);
                        $my_new_date = $a[2] . '/' . $a[1] . '/' . $a[0];
                        ?>  
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Opening Date<span style="color:red">*</span></label>
                            <div class="col-sm-6">  
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control"  id="opening_date" name="opening_date" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask name="dob" value="{{ $my_new_date }}" required="required">
                                    <span style="color: red"><?php echo $errors->branch->first('opening_date'); ?></span>
                                </div>
                            </div>
                        </div>                      
                        <div class="box-footer">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <button class="btn btn-primary" type="submit">Update</button>
                                <a href="{{URL::to('/')}}/branch" class="btn btn-danger" type="button">Cancel</a>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</section>

<script type="text/javascript">

    function getdistrictList(id) {
        $('#showloging').show();
        var value = id;
        $.ajax({
            type: "GET",
            url: "{{URL::to('/')}}/getdistrictList",
            data: {value: value},
            success: function (result) {
                if (result != '') {
                    $('#district').html(result);
                    $('#showloging').hide();
                } else {
                    $('#district').html('No District Found');
                }

            }
        }, "json");

    }

    function getupazilaList(id) {
        $('#showloging2').show();
        var value = id;
        $.ajax({
            type: "GET",
            url: "{{URL::to('/')}}/getupazilaList",
            data: {value: value},
            success: function (result) {
                if (result != '') {
                    $('#upazila').html(result);
                    $('#showloging2').hide();
                } else {
                    $('#upazila').html('No Upazila Found');
                }

            }
        }, "json");

    }

</script>
@stop