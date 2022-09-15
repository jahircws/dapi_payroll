@extends('layouts.app')

@section('pageStyles')

@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title w-100">Set Employee Salary
                        <a href="{{route('employee.salary')}}" class="btn btn-primary btn-md pull-right">Salary List</a>
                    </h4>
                </div>
                <div class="card-body">
                    @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible show fade">
                        <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        {{Session::get('error')}}
                        </div>
                    </div>
                    @endif
                    @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible show fade">
                        <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        {{Session::get('success')}}
                        </div>
                    </div>
                    @endif
                </div>
                <input type="hidden" name="employee_id" id="employee_id" value="{{$emps[0]->employee_id}}">
                <input type="hidden" name="emp_id" id="emp_id" value="{{$emps[0]->emp_id}}">
                <input type="hidden" name="basic_salary" id="basic_salary" value="{{$emps[0]->basic_amount}}">
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-md-6">
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title w-100">Employee Salary
                    <a href="javascript:;" class="btn btn-primary btn-icon pull-right" data-target="#basicModal" data-toggle="modal"><i data-feather="edit"></i></a>
                  </h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-6">
                    <h5>Payslip Type</h5>
                    {{ str_replace('_', ' ', $emps[0]->payslip_type) }}
                  </div>
                  <div class="col-sm-6">
                    <h5>Salary</h5>
                    <span>$</span>{{ $emps[0]->basic_amount }}
                  </div>
                </div>
              </div>
          </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
              <h4 class="card-title w-100">Allowance
                <a href="javascript:addEditAllowance('add', 0);;" class="btn btn-primary btn-icon pull-right"><i data-feather="plus"></i></a>
              </h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Allowance Option</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if (!empty($eearns))
                    @foreach($eearns as $eearn)
                    <tr>
                      <td>{{strtoupper($eearn->earning_options)}}</td>
                      <td>{{$eearn->title}}</td>
                      <td>{{strtoupper($eearn->type)}}</td>
                      <td> @if($eearn->type=='fixed') $ @endif{{$eearn->earning_value}}@if ($eearn->type=='percent') % @endif</td>
                      <td>
                        <a href="javascript:addEditAllowance('edit', {{$eearn->id}});" class="btn btn-primary btn-sm btn-icon mr-2"><i data-feather="edit"></i></a>
                        <a href="javascript:removeAllowance({{$eearn->id}});" class="btn btn-danger btn-sm btn-icon"><i data-feather="trash"></i></a>
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
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
              <h4 class="card-title w-100">Satutory Deduction
                <a href="javascript:addEditDeduction('add', 0);" class="btn btn-primary btn-icon pull-right"><i data-feather="plus"></i></a>
              </h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Deduction Option</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if (!empty($ededucts))
                    @foreach($ededucts as $ededuct)
                    <tr>
                      <td>{{strtoupper($ededuct->deduction_options)}}</td>
                      <td>{{$ededuct->title}}</td>
                      <td>{{strtoupper($ededuct->type)}}</td>
                      <td>@if($ededuct->type=='fixed') $ @endif{{$ededuct->deduct_value}}@if ($ededuct->type=='percent') % @endif</td>
                      <td>
                        <a href="javascript:addEditDeduction('edit', {{$ededuct->id}});" class="btn btn-primary btn-sm btn-icon mr-2"><i data-feather="edit"></i></a>
                        <a href="javascript:removeDeduction({{$ededuct->id}});" class="btn btn-danger btn-sm btn-icon"><i data-feather="trash"></i></a>
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
    </div>
</section>
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true" style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModal">Set Basic Salary</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('employee.store_salary')}}" id="frmBasic">
          @csrf
          <div class="form-group">
              <label for="payslip_type">Payslip Type <span class="text-danger">*</span></label>
              <select name="ddl_payslip_type" id="ddl_payslip_type" class="form-control">
                  {{-- <option value="HOURLY_PAYSLIP" @if($emps[0]->payslip_type == 'HOURLY_PAYSLIP') selected @endif>HOURLY PAYSLIP</option>
                  <option value="WEEKLY_PAYSLIP" @if($emps[0]->payslip_type == 'WEEKLY_PAYSLIP') selected @endif>WEEKLY PAYSLIP</option> --}}
                  <option value="MONTHLY_PAYSLIP" @if($emps[0]->payslip_type == 'MONTHLY_PAYSLIP') selected @endif>MONTHLY PAYSLIP</option>
              </select>
          </div>
          <div class="form-group">
            <label>Salary <span class="text-danger">*</span></label>
            <input type="text" name="salary" id="salary" class="form-control" value="{{$emps[0]->basic_amount}}">
          </div>
          <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="earningModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true" style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModal">Set Allowance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('employee.store_salary_allowances')}}" id="frmAllowance">
          @csrf
          <input type="hidden" name="ee_id" id="ee_id" value="0">
          <div class="form-group">
              <label for="earning_option">Allowance Options <span class="text-danger">*</span></label>
              <select name="earning_option" id="earning_option" class="form-control">
                  <option value="taxable">TAXABLE</option>
                  <option value="non-taxable">NON TAXABLE</option>
              </select>
          </div>
          <div class="form-group">
            <label>Title <span class="text-danger">*</span></label>
            <input type="text" name="eetitle" id="eetitle" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="earning_type">Type <span class="text-danger">*</span></label>
            <select name="earning_type" id="earning_type" class="form-control">
              <option value="fixed">FIXED</option>
              <option value="percent">PERCENTAGE</option>
            </select>
        </div>
        <div class="form-group">
          <label>Value <span class="text-danger">*</span></label>
          <input type="text" name="earning_value" id="earning_value" class="form-control" value="">
        </div>
          <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="deductModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true" style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModal">Set Deduction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('employee.store_salary_deduction')}}" id="frmDeduction">
          @csrf
          <input type="hidden" name="ed_id" id="ed_id" value="0">
          <div class="form-group">
              <label for="deduct_option">Deduction Options <span class="text-danger">*</span></label>
              <select name="deduct_option" id="deduct_option" class="form-control">
                  <option value="taxable">TAXABLE</option>
                  <option value="non-taxable">NON TAXABLE</option>
              </select>
          </div>
          <div class="form-group">
            <label>Title <span class="text-danger">*</span></label>
            <input type="text" name="edtitle" id="edtitle" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="deduct_type">Type <span class="text-danger">*</span></label>
            <select name="deduct_type" id="deduct_type" class="form-control">
                <option value="fixed">FIXED</option>
                <option value="percent">PERCENTAGE</option>
            </select>
        </div>
        <div class="form-group">
          <label for="deduct_value">Value <span class="text-danger">*</span></label>
          <input type="text" name="deduct_value" id="deduct_value" class="form-control" value="">
        </div>
          <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('pageScripts')
<script src="{{asset('assets/bundles/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script>
  var _token = '{{csrf_token()}}';

  $(function(){
    $('#frmBasic').validate({
      rules: {
        'salary': {
          required: true,
          digits: true
        }
      },
      submitHandler: (form, e)=>{
        e.preventDefault();
        var frmData = new FormData($('#frmBasic')[0]);
        frmData.append('employee_id', $('#employee_id').val());
        frmData.append('emp_id', $('#emp_id').val());
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': _token,
          },
          url: form.action,
          method: 'POST',
          data: frmData,
          dataType: 'json',
          processData: false,
          contentType: false,
          success: (respond)=>{
            if(respond.status){
              window.location.reload();
            }else{
              alert('Failed to add.');
            }
          },
          error: (err)=>{
            alert(err.responseJSON.message);
          }
        });
        
      }
    });

    $('#frmAllowance').validate({
      rules: {
        'earning_option': {
          required: true
        },
        'eetitle': {
          required: true
        },
        'earning_type': {
          required: true
        },
        'earning_value': {
          required: true,
          number: true
        }
      },
      submitHandler: (form, e)=>{
        e.preventDefault();
        var frmData = new FormData($('#frmAllowance')[0]);
        frmData.append('employee_id', $('#employee_id').val());
        frmData.append('emp_id', $('#emp_id').val());
        frmData.append('basic_salary', $('#basic_salary').val());
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': _token,
          },
          url: form.action,
          method: 'POST',
          data: frmData,
          dataType: 'json',
          processData: false,
          contentType: false,
          success: (respond)=>{
            if(respond.status){
              window.location.reload();
            }else{
              alert('Failed to add.');
            }
          },
          error: (err)=>{
            alert(err.responseJSON.message);
          }
        });
      }
    });

    $('#frmDeduction').validate({
      rules: {
        'deduct_option': {
          required: true
        },
        'edtitle': {
          required: true
        },
        'deduct_type': {
          required: true
        },
        'deduct_value': {
          required: true,
          number: true
        }
      },
      submitHandler: (form, e)=>{
        e.preventDefault();
        var frmData = new FormData($('#frmDeduction')[0]);
        frmData.append('employee_id', $('#employee_id').val());
        frmData.append('emp_id', $('#emp_id').val());
        frmData.append('basic_salary', $('#basic_salary').val());
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': _token,
          },
          url: form.action,
          method: 'POST',
          data: frmData,
          dataType: 'json',
          processData: false,
          contentType: false,
          success: (respond)=>{
            if(respond.status){
              window.location.reload();
            }else{
              alert('Failed to add.');
            }
          },
          error: (err)=>{
            alert(err.responseJSON.message);
          }
        });
      }
    });

  });

  function addEditAllowance(action, prim_id){
    $('#frmAllowance')[0].reset();
    if(action == 'add'){
      
      $('#ee_id').val(0);
      $('#earningModal').modal('show');
    }else{
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': _token,
        },
        url: `${baseURL}/employee/get_emp_allowance_details`,
        method: 'GET',
        data: { id: prim_id },
        dataType: 'json',
        success: (respond)=>{
          if(respond.status){
            $('#ee_id').val(respond.data[0].id);
            $('#earning_option').val(respond.data[0].earning_options);
            $('#eetitle').val(respond.data[0].title);
            $('#earning_type').val(respond.data[0].type);
            $('#earning_value').val(respond.data[0].earning_value);
            $('#earningModal').modal('show');
          }else{
            alert('Not found.');
          }
        },
        error: (err)=>{
          alert('something went wrong.');
        }
      });
    }
  }
  function removeAllowance(prim_id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to remove this allowance',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        showLoaderOnConfirm: true,
        preConfirm: (respond)=>{
            if(respond){
                return fetch(`${baseURL}/employee/delete_allowance`, {
                    method: 'delete', 
                    headers:{
                        Accept: 'application.json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        '_token': _token,
                        'id': prim_id
                    })
                })
                .then(response => {
                    if (!response.ok) {
                    throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                    `Request failed: ${error}`
                    )
                })
            }
        },
        allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
        if (result.isConfirmed) {
            if(result.value){
                alert('Deleted successfully');
                window.location.reload();
            }else{
                alert('Failed to delete')
            }
        }
    });
  }

  function addEditDeduction(action, prim_id){
    $('#frmDeduction')[0].reset();
    if(action == 'add'){
      
      $('#ed_id').val(0);
      $('#deductModal').modal('show');
    }else{
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': _token,
        },
        url: `${baseURL}/employee/get_emp_deduction_details`,
        method: 'GET',
        data: { id: prim_id },
        dataType: 'json',
        success: (respond)=>{
          if(respond.status){
            $('#ed_id').val(respond.data[0].id);
            $('#deduct_option').val(respond.data[0].deduction_options);
            $('#edtitle').val(respond.data[0].title);
            $('#deduct_type').val(respond.data[0].type);
            $('#deduct_value').val(respond.data[0].deduct_value);
            $('#deductModal').modal('show');
          }else{
            alert('Not found.');
          }
        },
        error: (err)=>{
          alert('something went wrong.');
        }
      });
    }
  }
  function removeDeduction(prim_id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to remove this deduction',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        showLoaderOnConfirm: true,
        preConfirm: (respond)=>{
            if(respond){
                return fetch(`${baseURL}/employee/delete_deduction`, {
                    method: 'delete', 
                    headers:{
                        Accept: 'application.json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        '_token': _token,
                        'id': prim_id
                    })
                })
                .then(response => {
                    if (!response.ok) {
                    throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                    `Request failed: ${error}`
                    )
                })
            }
        },
        allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
        if (result.isConfirmed) {
            if(result.value){
                alert('Deleted successfully');
                window.location.reload();
            }else{
                alert('Failed to delete')
            }
        }
    });
  }
</script>
@endsection