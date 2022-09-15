@extends('layouts.app')

@section('pageStyles')
<script>var _token = '{{csrf_token()}}';</script>
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Run Payroll</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{route('employee.get_payroll')}}" method="get" id="frmGetPay">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select name="ddl_month" id="ddl_month" class="form-control">
                                                <option value="">Month</option>
                                                @foreach ($months as $key=>$month)
                                                <option value="{{$key + 1}}">{{$month}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <select name="ddl_year" id="ddl_year" class="form-control">
                                                <option value="">Year</option>
                                                @php
                                                    $year = date('Y');
                                                @endphp
                                                @for ($i = $year; $i >= ($year-5); $i--)
                                                <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group"><button type="submit" id="btn_generate" class="btn btn-success btn-block">Generate/View</button></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Employee Payslip</h4>
                </div>
                <div class="card-body" id="calc_payroll"></div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('pageScripts')
<script>
    
    $('#frmGetPay').on('submit', (e)=>{
        e.preventDefault();
        var month = $('#ddl_month').val();
        var year = $('#ddl_year').val();
        get_payslips(month, year);
    });

    function get_payslips(month, year) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': _token,
            },
            url: `${baseURL}/employee/get_payroll`,
            method: 'GET',
            data: { month: month, year: year },
            success: (respond)=>{
                $('#calc_payroll').html(respond);
            },
            error: (err)=>{
                alert(err.responseJSON.message);
            }
        });
    }
</script>
@endsection