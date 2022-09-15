
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <th>EMPLOYEE ID</th>
            <th>NAME</th>
            <th>NET SALARY</th>
            <th>OUTFLOW</th>
            <th>STATUS</th>
            <th>ACTION</th>
        </thead>
        <tbody>
            @if ($emps)
                @foreach($emps as $emp)
                @php $id = $emp->id; @endphp
                <tr>
                    <td>{{$emp->employee_id}}</td>
                    <td>{{$emp->fullname}}</td>
                    <td>${{$emp->net_salary}}</td>
                    <td>${{$emp->outflow}}</td>
                    <td>{{$emp->payment_status}}</td>
                    <td>
                        @if ($emp->payment_status == 'UnPaid')
                            <a href="javascript:completePayment({{$id}});" id="btn_pay_{{$id}}" class="btn btn-success">Click to Pay</a>
                        @endif    
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
<script>
    function completePayment(prim_id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': _token,
            },
            beforeSend: ()=>{
                $('#btn_pay_'+prim_id).addClass('btn-progress');
                $('#btn_pay_'+prim_id).attr('disabled', true);
            },
            url: `${baseURL}/employee/give_payment`,
            method: 'PUT',
            data: { id: prim_id },
            dataType: 'json',
            success: (respond)=>{
                if(respond.status){
                    get_payslips('{{$month}}', '{{$year}}');
                }else{
                    $('#btn_pay_'+prim_id).removeClass('btn-progress');
                    $('#btn_pay_'+prim_id).removeAttr('disabled');
                    alert('Failed to make payment');
                }
            },
            error: (err)=>{
                $('#btn_pay_'+prim_id).removeClass('btn-progress');
                $('#btn_pay_'+prim_id).removeAttr('disabled');
                alert('Unable to connect');
            }
        });
    }
</script>