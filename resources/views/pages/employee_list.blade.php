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
                    <h4 class="card-title w-100">Employee List
                        <a href="{{route('employee.add')}}" class="btn btn-primary btn-md pull-right">Add Employee</a>
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
                    <div class="table-responsive">
                        <table class="table table-striped" id="tbl-emp">
                            <thead>
                                <tr>
                                    <th>EMPLOYEE ID</th>
                                    <th>NAME</th>
                                    <th>EMAIL</th>
                                    <th>DEPARTMENT</th>
                                    <th>DESIGNATION</th>
                                    <th>DATE OF JOINING</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (!empty($emps))
                                @php $i=1; @endphp
                                @foreach ($emps as $emp)
                                    <tr>
                                        <td><button type="button" class="btn btn-success">#{{$emp->emp_id}}</button></td>
                                        <td>{{$emp->fullname}}</td>
                                        <td>{{$emp->email}}</td>
                                        <td>{{$emp->department_name}}</td>
                                        <td>{{$emp->designation_name}}</td>
                                        <td>{{date('jS M Y', strtotime($emp->date_of_joining))}}</td>
                                        <td>
                                            <a href="#" class="btn btn-success btn-icon"><i class="fas fa-edit"></i></a>
                                            <form action="{{route('employee.delete')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="emp_id" value="{{$emp->id}}" />
                                                <button type="submit" class="btn btn-danger btn-icon"><i class="fas fa-trash"></i></button>
                                            </form>
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