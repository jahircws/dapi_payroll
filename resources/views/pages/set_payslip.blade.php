<form action="#" method="post" id="frmGenerate">
    <input type="hidden" name="mp_id" id="mp_id" value="{{$mp_id}}">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <th>EMPLOYEE ID</th>
                <th>NAME</th>
                <th>SALARY</th>
                <th>ALLOWANCES</th>
                <th>DEDUCTIONS</th>
                <th>BONUS</th>
                <th>COMMISSION</th>
                <th>REIMBUSRTMENT</th>
                <th>ADJUSTMENT</th>
            </thead>
            <tbody>
                @if ($emps)
                    @foreach($emps as $emp)
                    @php $id = $emp->id; @endphp
                    <tr>
                        <td>{{$emp->employee_id}} <input type="hidden" name="empay_id[]" id="empay_id_{{$id}}" value="{{$id}}"></td>
                        <td>{{$emp->fullname}}</td>
                        <td>${{$emp->basic}} <input type="hidden" name="basics_{{$id}}" id="basics_{{$id}}" value="{{$emp->basic}}"></td>
                        <td>${{$emp->earnings}} <input type="hidden" name="earns_{{$id}}" id="earns_{{$id}}" value="{{$emp->earnings}}"></td>
                        <td>${{$emp->deductions}} <input type="hidden" name="deducts_{{$id}}" id="deducts_{{$id}}" value="{{$emp->deductions}}"></td>
                        <td><input type="number" name="bonus_{{$id}}" id="bonus_{{$id}}" class="form-control"></td>
                        <td><input type="number" name="commission_{{$id}}" id="commission_{{$id}}" class="form-control"></td>
                        <td><input type="number" name="reimburstment_{{$id}}" id="reimburstment_{{$id}}" class="form-control"></td>
                        <td><input type="number" name="adjustment_{{$id}}" id="adjustment_{{$id}}" class="form-control"></td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div class="form-group"><button type="submit" class="btn btn-primary btn-block">Process Input and Final</button></div>
</form>

<script>
    $('#frmGenerate').on('submit', (e)=>{
        e.preventDefault();
        if(confirm('Do you want to proceed? You cannot revert back the chnages.')){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': _token,
                },
                url: `${baseURL}/employee/generate_payslip`,
                method: 'POST',
                data: new FormData($('#frmGenerate')[0]),
                contentType: false,
                processData: false,
                dataType: 'json',
                success: (respond)=>{
                    console.log(respond);
                    get_payslips('{{$month}}', '{{$year}}');
                },
                error: (err)=>{
                    console.error(err)
                }
            });
        }else{
            alert('no-go')
        }
    })
</script>