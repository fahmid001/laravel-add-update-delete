@extends('controlpanel/mainlayout')

@section('content')
<div class="directions">
    <section class="content-header">
        <h1>
            Branch
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
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Branch List</h3>
                </div>
                <span class="tools pull-right" style="padding:0px 10px 5px 0px">
                    <a class="btn btn-success" href="{{URL::to('add-branch')}}">Add Branch<i class="fa fa-plus"></i></a>
                </span>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl. </th>
                                <th>Branch Name</th>
                                <th>Branch Code</th>
                                <th>Branch Type</th>
                                <th>Address</th>
                                <th>Phone No.</th>
                                <th>Opening Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl_cnt = 1 ?>
                            @if($branchInfo)
                            @foreach ($branchInfo as $rowdata)
                            <tr>
                                <td>{{ $sl_cnt++ }}.</td>
                                <td>{{ $rowdata->bra_name }}</td>
                                <td>{{ $rowdata->bra_code }}</td>
                                <td>{{ $rowdata->bra_type }}</td>
                                <td>{{ $rowdata->bra_address }}</td>
                                <td>{{ $rowdata->bra_phone }}</td>
                                <?php
                                $a = explode('-', $rowdata->bra_openingdate);
                                $my_new_date = $a[2] . '/' . $a[1] . '/' . $a[0];
                                ?>  
                                <td>{{ $my_new_date }}</td>
                                <td>
                                    <a class="btn btn-success btn-xs" href="{{URL::to('/')}}/details-branch/{{Crypt::encrypt($rowdata->id)}}">View</a>
                                    <a class="btn btn-primary btn-xs" href="{{URL::to('/')}}/edit-branch/{{Crypt::encrypt($rowdata->id)}}">Edit</a>
                                    <a class="btn btn-danger btn-xs" href="{{URL::to('/')}}/delete-branch/{{Crypt::encrypt($rowdata->id)}}" onclick="return confirm('Are you sure want to delete !!!')">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>	
<script src="{{ URL::asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#example1').dataTable();
});
</script>
@stop