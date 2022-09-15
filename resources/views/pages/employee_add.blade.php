@extends('layouts.app')

@section('pageStyles')
<link rel="stylesheet" href="{{asset('assets/bundles/bootstrap-daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="{{asset('assets/bundles/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/bundles/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/bundles/jquery-selectric/selectric.css')}}">
<link rel="stylesheet" href="{{asset('assets/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}">
<style>
    .error{
        color: red !important;
    }
</style>
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title w-100">Add Employee
                        <a href="{{route('employee.list')}}" class="btn btn-primary btn-md pull-right">Employee List</a>
                    </h4>
                </div>
            </div>
        </div>
    </div>
    <form action="{{route('employee.save')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Personal Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="first_name">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" value="{{old('first_name')}}">
                                    <span class="error">@error('first_name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" value="{{old('last_name')}}">
                                    <span class="error">@error('last_name') {{$message}} @enderror</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="dob">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="text" name="dob" id="dob" class="form-control datepicker" value="{{old('dob')}}">
                                    <span class="error">@error('dob') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-sm-6 justify-content-center align-items-center">
                                <label for="gender">Gender <span class="text-danger">*</span></label><br>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="male" name="gender" value="male" @if (old('gender') == 'male') checked="true" @endif class="custom-control-input">
                                    <label class="custom-control-label" for="male">Male</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="female" name="gender" value="female" @if (old('gender') == 'female') checked="true" @endif class="custom-control-input">
                                    <label class="custom-control-label" for="female">Female</label>
                                </div>
                                <span class="error">@error('gender') {{$message}} @enderror</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
                                    <span class="error">@error('email') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="mobile">Mobile <span class="text-danger">*</span></label>
                                    <input type="text" name="mobile" id="mobile" class="form-control" value="{{old('mobile')}}">
                                    <span class="error">@error('mobile') {{$message}} @enderror</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Home Address</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{old('address')}}">
                            <span class="error">@error('address') {{$message}} @enderror</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card align-items-stretch">
                    <div class="card-header">
                        <h4 class="card-title">Company Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="emp_id">Employee ID</label>
                            <input type="text" name="emp_id" id="emp_id" class="form-control" readonly disabled="true" value="#EMP00004">
                        </div>
                        <div class="form-group">
                            <label for="ddl_designation">Role</label>
                            <select name="ddl_designation" id="ddl_designation" class="form-control">
                                <option value="">Select Designation</option>
                                @foreach ($designation as $design)
                                    @if (old('ddl_designation') == $design->id)
                                    <option value="{{$design->id}}" selected="true">{{$design->designation_name}}</option>
                                    @else
                                    <option value="{{$design->id}}">{{$design->designation_name}}</option>
                                    @endif
                                    
                                @endforeach
                            </select>
                            <span class="error">@error('ddl_designation') {{$message}} @enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="emirates_card">Emirates ID Card</label>
                            <input type="text" name="emirates_card" id="emirates_card" class="form-control" value="{{old('emirates_card')}}">
                            <span class="error">@error('emirates_card') {{$message}} @enderror</span>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="emirates_exp">Exipres at <span class="text-danger">*</span></label>
                                    <input type="text" name="emirates_exp" id="emirates_exp" class="form-control datepicker" value="{{old('emirates_exp')}}">
                                    <span class="error">@error('emirates_exp') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="doj">Date of Joining <span class="text-danger">*</span></label>
                                    <input type="text" name="doj" id="doj" class="form-control datepicker" value="{{old('doj')}}">
                                    <span class="error">@error('doj') {{$message}} @enderror</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Bank Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="accountNumber">Account Number</label>
                            <input type="text" name="acountNumber" id="acountNumber" class="form-control" value={{old('acountNumber')}}>
                            <span class="error">@error('acountNumber') {{$message}} @enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="iban">IBAN</label>
                            <input type="text" name="iban" id="iban" class="form-control" value="{{old('iban')}}">
                            <span class="error">@error('iban') {{$message}} @enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="swift_code">Swift Code</label>
                            <input type="text" name="swift_code" id="swift_code" class="form-control" value="{{old('swift_code')}}">
                            <span class="error">@error('swift_code') {{$message}} @enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="bank_name">Bank Name</label>
                            <input type="text" name="bank_name" id="bank_name" class="form-control" value="{{old('bank_name')}}">
                            <span class="error">@error('bank_name') {{$message}} @enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="branch_name">Branch Name</label>
                            <input type="text" name="branch_name" id="branch_name" class="form-control" value="{{old('branch_name')}}">
                            <span class="error">@error('branch_name') {{$message}} @enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="branch_address">Branch Address</label>
                            <input type="text" name="branch_address" id="branch_address" class="form-control" value="{{old('branch_address')}}">
                            <span class="error">@error('branch_address') {{$message}} @enderror</span>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="holder_name">Holder Name</label>
                                    <input type="text" name="holder_name" id="holder_name" class="form-control" value="{{old('holder_name')}}">
                                    <span class="error">@error('holder_name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="nick_name">Holder Nick Name</label>
                                    <input type="text" name="nick_name" id="nick_name" class="form-control" value="{{old('nick_name')}}">
                                    <span class="error">@error('nick_name') {{$message}} @enderror</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" name="country" id="country" class="form-control" value="{{old('country')}}">
                                    <span class="error">@error('country') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" name="city" id="city" class="form-control" value="{{old('city')}}">
                                    <span class="error">@error('city') {{$message}} @enderror</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="street_address">Street Address</label>
                            <input type="text" name="street_address" id="street_address" class="form-control" value="{{old('street_address')}}">
                            <span class="error">@error('street_address') {{$message}} @enderror</span>
                        </div>
                    </div>  
                </div>
            </div>
            <div class="col-md-6">
    
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Create</button>
        </div>
    </form>
</section>
@endsection

@section('pageScripts')
<script src="{{asset('assets/bundles/cleave-js/dist/cleave.min.js')}}"></script>
<script src="{{asset('assets/bundles/cleave-js/dist/addons/cleave-phone.us.js')}}"></script>
<script src="{{asset('assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js')}}"></script>
<script src="{{asset('assets/bundles/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('assets/bundles/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{asset('assets/bundles/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
<script src="{{asset('assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
<script src="{{asset('assets/bundles/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{asset('assets/bundles/jquery-selectric/jquery.selectric.min.js')}}"></script>
@endsection