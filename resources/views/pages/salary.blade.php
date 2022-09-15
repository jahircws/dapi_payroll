@extends('layouts.app')

@section('pageStyles')
<link rel="stylesheet" href="{{asset('assets/bundles/datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title w-100">Set Salary</h4>
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
                    <div class="table-responsive">
                        <table class="table table-striped" id="tbl-emp">
                            <thead>
                                <tr>
                                    <th width="10%">EMPLOYEE ID</th>
                                    <th width="35%">NAME</th>
                                    <th width="30%">SALARY</th>
                                    <th width="30%">NET SALARY</th>
                                    <th width="5%">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (!empty($emps))
                                @php $i=1; @endphp
                                @foreach ($emps as $emp)
                                    <tr>
                                        <td><a href="{{route('employee.set_salary', ['id'=>$emp->employee_id])}}" class="btn btn-success">#{{$emp->employee_id}}</a></td>
                                        <td>{{$emp->fullname}}</td>
                                        <td>${{$emp->basic_amount}}</td>
                                        <td>${{ ($emp->basic_amount + $emp->earnings) - $emp->deductions }}</td>
                                        <td>
                                            <a href="#" class="btn btn-success btn-icon"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
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
@endsection

@section('pageScripts')
<script src="{{asset('assets/bundles/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/bundles/jquery-ui/jquery-ui.min.js')}}"></script>
@endsection