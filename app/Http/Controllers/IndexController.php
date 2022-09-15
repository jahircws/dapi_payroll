<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Reponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Employee;

class IndexController extends Controller
{
    public function dashboard()
    {
        return view('pages.dashboard');
    }

    public function employee_list()
    {
        $data['emps'] = DB::table('employees')->join('departments', 'employees.department_id', '=', 'departments.id')->join('designations', 'employees.designation_id', '=', 'designations.id')->select('employees.*', 'departments.department_name', 'designations.designation_name')->get();

        return view('pages.employee_list')->with($data);
    }

    public function employee_add()
    {
        //$data['department'] = DB::table('departments')->get();
        $data['designation'] = DB::table('designations')->get();
        return view('pages.employee_add')->with($data);
    }

    private function generate_employee_id()
    {
        $lastID = DB::table('employees')->max('id');
        return is_null($lastID) ? 1 : $lastID+1;
    }

    public function employee_store(Request $request)
    {
        // $validation = Validation::make($request->all(), [
        //     'first_name'=>'required|max:255',
        //     'last_name'=>'required|max:255',
        //     'email'=>'required|email|unique:employees,email',
        //     'gender'=>'required|date',
        //     'ddl_designation'=>'required',
        //     'emirates_card'=>'required|min:18|max:18|regex:/^784-[0-9]{4}-[0-9]{7}-[0-9]{1}$/',
        //     'emirates_exp'=>'requried|date',
        //     'doj'=>'required|date',
        //     'acountNumber'=>'numeric|digits_between:5,26',
        //     'iban'=>'aplha_num',
        //     'swift_code'=>'alpha_dash',
        //     'bank_name'=>'alpha',
        //     'branch_name'=>'alpha',
        //     'branch_country'=>'alpha',
        //     'branch_address'=>'alpha',
        //     'holder_name'=>'alpha',
        //     'nick_name'=>'alpha',
        //     'country'=>'alpha',
        //     'city'=>'alpha',
        //     'street_address'=>'alpha'
        // ], [
        //     'email.unique'=>'This email already exists.',
        //     'emirates_card.regex'=>'The card number is invalid.'
        // ], [
        //     'first_name'=>'Firstname',
        //     'last_name'=>'Lastname',
        //     'email'=>'Email',
        //     'gender'=>'Gender',
        //     'ddl_designation'=>'Designation',
        //     'emirates_card'=>'Emirates Card',
        //     'emirates_exp'=>'Emirates Expires',
        //     'doj'=>'Date of Joining',
        //     'acountNumber'=>'Account Number',
        //     'iban'=>'IBAN',
        //     'swift_code'=>'Swift Code',
        //     'bank_name'=>'Bank Name',
        //     'branch_name'=>'Branch Name',
        //     'branch_country'=>'Branch Country',
        //     'branch_address'=>'Branch Address',
        //     'holder_name'=>'Holder Name',
        //     'nick_name'=>'Nick Name',
        //     'country'=>'Holder Country',
        //     'city'=>'Holder City',
        //     'street_address'=>'Holder Street Address'
        // ]);

        // if ($validator->fails())
        // {
        //     // return redirect('post/create')
        //     //                 ->withErrors($validator)
        //     //                 ->withInput();
        //     return response()->json(array(
        //         'status' => false,
        //         'verrors' => $validator->getMessageBag()->toArray(),
        //         'errors'=>""
        //     ), 400); // 400 being the HTTP code for an invalid request.
        // }

        $request->validate([
            'first_name'=>'required|max:255',
            'last_name'=>'required|max:255',
            'email'=>'required|email|unique:employees,email',
            'mobile'=>'required|regex:/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s. ]\d{3}[\s. ]\d{4}$/i',
            'gender'=>'required',
            'ddl_designation'=>'required',
            'emirates_card'=>'required|min:18|max:18|regex:/^784-[0-9]{4}-[0-9]{7}-[0-9]{1}$/',
            'emirates_exp'=>'required|date',
            'doj'=>'required|date',
            'acountNumber'=>'numeric|digits_between:5,26',
            'iban'=>'alpha_num',
            'swift_code'=>'alpha_dash',
            'bank_name'=>'string',
            'branch_name'=>'string',
            'branch_country'=>'string',
            'branch_address'=>'string',
            'holder_name'=>'string',
            'nick_name'=>'string',
            'country'=>'string',
            'city'=>'string',
            'street_address'=>'string'
        ], [
            'email.unique'=>'This email already exists.',
            'mobile.regex'=>'Invalid format mobile number',
            'emirates_card.regex'=>'The emirate card number is invalid.'
        ], [
            'first_name'=>'Firstname',
            'last_name'=>'Lastname',
            'email'=>'Email',
            'gender'=>'Gender',
            'ddl_designation'=>'Designation',
            'emirates_card'=>'Emirates Card',
            'emirates_exp'=>'Emirates Expires',
            'doj'=>'Date of Joining',
            'acountNumber'=>'Account Number',
            'iban'=>'IBAN',
            'swift_code'=>'Swift Code',
            'bank_name'=>'Bank Name',
            'branch_name'=>'Branch Name',
            'branch_country'=>'Branch Country',
            'branch_address'=>'Branch Address',
            'holder_name'=>'Holder Name',
            'nick_name'=>'Nick Name',
            'country'=>'Holder Country',
            'city'=>'Holder City',
            'street_address'=>'Holder Street Address'
        ]);

        $data['first_name'] = $request->post('first_name');
        $data['last_name'] = $request->post('last_name');
        $data['fullname'] = trim($data['first_name'].' '.$data['last_name']);
        //$data['dob'] = date('Y-m-d', strtotime($request->post('dob')));
        $data['gender'] = $request->post('gender');
        $data['email'] = $request->post('email');
        //$data['mobile'] = $request->post('mobile');
        $data['designation_id'] = $request->post('ddl_designation');
        $data['department_id'] = 1;
        $data['emirates_id'] = $request->post('emirates_card');
        $data['emirates_exp'] = date('Y-m-d', strtotime($request->post('emirates_exp')));
        $data['date_of_joining'] = date('Y-m-d', strtotime($request->post('doj')));
        $data['emp_id'] = 'EMP'.$this->generate_employee_id().time();
        $data['created_at'] = date('Y-m-d H:i:s', time());
        $data['status'] = 'active';

        $ebank['iban'] = $request->post('iban');
        $ebank['swift_code'] = $request->post('swift_code');
        $ebank['account_num'] = $request->post('acountNumber');
        $ebank['bank_name'] = $request->post('bank_name');
        $ebank['branch_name'] = $request->post('branch_name');
        $ebank['branch_address'] = $request->post('branch_address');
        $ebank['holder_name'] = $request->post('holder_name');
        $ebank['holder_nick_name'] = $request->post('nick_name');
        $ebank['country'] = $request->post('country');
        $ebank['city'] = $request->post('city');
        $ebank['street_address'] = $request->post('street_address');
        $ebank['created_at'] = date('Y-m-d H:i:s', time());

        $esalary['payslip_type'] = "MONTHLY_PAYSLIP";
        $esalary['basic_amount'] = 0;
        $esalary['created_at'] = date('Y-m-d H:i:s', time());

        $id = DB::table('employees')->insertGetId($data);

        $esalary['emp_id'] = $ebank['emp_id'] = $id;
        DB::table('employee_bank_details')->insert($ebank);
        DB::table('employee_salaries')->insert($esalary);

        return redirect()->route('employee.list');
    }

    public function employee_delete(Request $request)
    {
        $id = $request->post('emp_id');

        if(Employee::find($id)){
            DB::table('employees')->where('id', $id)->delete();
            return redirect()->route('employee.list')->with('success', 'Employee delete successfull.');
        }else{
            return redirect()->route('employee.list')->with('error', 'Employee not found.');
        }
    }

    /* =============================================================================================================== */
    public function salary(Request $request)
    {
        $data['emps'] = DB::table('employee_salaries as es')
            ->join('employees', 'es.emp_id', '=', 'employees.id')
            ->select(DB::raw('es.*, employees.fullname, employees.emp_id as employee_id, (SELECT SUM(calc_earning) from employee_earnings ee where ee.emp_id = employees.id ) as earnings, (SELECT SUM(calc_deduct) from employee_deductions ee where ee.emp_id = employees.id ) as deductions'))
            ->get();
        //'e.*', 'employees.emp_id as employee_id', 'employees.fullname', DB::raw(''
        return view('pages.salary')->with($data);
    }

    public function set_salary(Request $request, $id)
    {
        if(Employee::where('emp_id', $id)->first()){

            $data['emps'] = DB::table('employee_salaries')
                ->join('employees', 'employee_salaries.emp_id', '=', 'employees.id')
                ->select('employee_salaries.*', 'employees.emp_id as employee_id', 'employees.fullname')
                ->where('employees.emp_id', $id)
                ->get();
            
            $data['eearns'] = DB::table('employee_earnings')->where('emp_id', $data['emps'][0]->emp_id)->get();
            $data['ededucts'] = DB::table('employee_deductions')->where('emp_id', $data['emps'][0]->emp_id)->get();

            return view('pages.set_salary')->with($data);
        }else{
            return redirect()->route('employee.salary')->with('error', 'Employee not found.');
        }
    }

    public function store_salary(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'salary'=>'required|numeric'
        ]);

        if ($validation->fails())
        {
            return response()->json(array(
                'status' => false,
                'verrors' => $validation->getMessageBag()->toArray(),
                'errors'=>""
            ), 400); // 400 being the HTTP code for an invalid request.
        }

        $emp_id = $request->post('emp_id');

        $esalary['payslip_type'] = $request->post('ddl_payslip_type');
        $esalary['basic_amount'] = $request->post('salary');
        $esalary['updated_at'] = date('Y-m-d H:i:s', time());

        if(DB::table('employee_salaries')->where('emp_id', $emp_id)->update($esalary)){
            return response()->json(array('status'=>true), 200);
        }else{
            return response()->json(array('status'=>false), 200);
        }
    }

    public function get_emp_allowance_details(Request $request)
    {
        $id = $request->get('id');

        $data = DB::table('employee_earnings')->where('id', $id)->get();
        if(!empty($data)){
            return response()->json(array('status'=>true, 'data'=>$data), 200);
        }else{
            return response()->json(array('status'=>false), 200);
        }
    }
    public function store_salary_allowances(Request $request)
    {
        $ee_id = $request->post('ee_id');
        $emp_id = (int)$request->post('emp_id');
        $bsalary = (int)$request->post('basic_salary');

        if($bsalary != 0){
            $validation = Validator::make($request->all(), [
                'earning_option'=>'required',
                'eetitle'=>[
                    'required',
                    'string',
                    // Rule::unique('employee_earnings')->where(fn ($query) => $query->where('emp_id', $emp_id)),
                    // function ($attribute, $value, $fail) {
                    //     return !! (DB::table('employee_earnings')
                    //         ->where('emp_id', $emp_id)
                    //         ->get()
                    //         ->contains('title', $value)
                    //     );
                    // },
                ],
                'earning_type'=>'required',
                'earning_value'=>'required|numeric'
            ]);
            //
            if ($validation->fails())
            {
                return response()->json(array(
                    'status' => false,
                    'verrors' => $validation->getMessageBag()->toArray(),
                    'errors'=>""
                ), 400); // 400 being the HTTP code for an invalid request.
            }
            //$bsalary
            $eearn['emp_id'] = $emp_id;
            $eearn['earning_options'] = $request->post('earning_option');
            $eearn['title'] = $request->post('eetitle');
            $eearn['type'] = $request->post('earning_type');
            $eearn['earning_value'] = (float)$request->post('earning_value');
            $eearn['calc_earning'] = ($eearn['type'] === 'fixed')? $eearn['earning_value'] : round(($bsalary*$eearn['earning_value'])/100, 2);

            if($ee_id == 0){
                $eearn['created_at'] = date('Y-m-d H:i:s', time());
                if(DB::table('employee_earnings')->insert($eearn)){
                    return response()->json(array('status'=>true), 200);
                }else{
                    return response()->json(array('status'=>false), 200);
                }
            }else{
                $eearn['updated_at'] = date('Y-m-d H:i:s', time());
                if(DB::table('employee_earnings')->where('id', $ee_id)->update($eearn)){
                    return response()->json(array('status'=>true), 200);
                }else{
                    return response()->json(array('status'=>false), 200);
                }
            }
        }else{
            return response()->json(array('status'=>false, 'message'=>'Add salary first'), 200);
        }
    }
    public function delete_allowance(Request $request)
    {
        $status = false;
        $id = $request->post('id');
        
        if(!empty(DB::table('employee_earnings')->where('id', $id)->first())){
            $status = DB::table('employee_earnings')->where('id', $id)->delete();
        }
        return $status;
    }

    /* ========================================================================================================== */

    public function get_emp_deduction_details(Request $request)
    {
        $id = $request->get('id');

        $data = DB::table('employee_deductions')->where('id', $id)->get();
        if(!empty($data)){
            return response()->json(array('status'=>true, 'data'=>$data), 200);
        }else{
            return response()->json(array('status'=>false), 200);
        }
    }
    public function store_salary_deduction(Request $request)
    {
        $ed_id = $request->post('ed_id');
        $emp_id = $request->post('emp_id');
        $bsalary = (int)$request->post('basic_salary');

        if($bsalary !== 0){
            $validation = Validator::make($request->all(), [
                'deduct_option'=>'required',
                'edtitle'=>'required|string'.( $ed_id==0 ? '|unique:employee_deductions,title,emp_id,'.$emp_id : ''),
                'deduct_type'=>'required',
                'deduct_value'=>'required|numeric'
            ]);
    
            if ($validation->fails())
            {
                return response()->json(array(
                    'status' => false,
                    'verrors' => $validation->getMessageBag()->toArray(),
                    'errors'=>""
                ), 400); // 400 being the HTTP code for an invalid request.
            }
    
            $ededuct['emp_id'] = $emp_id;
            $ededuct['deduction_options'] = $request->post('deduct_option');
            $ededuct['title'] = $request->post('edtitle');
            $ededuct['type'] = $request->post('deduct_type');
            $ededuct['deduct_value'] = $request->post('deduct_value');
            $ededuct['calc_deduct'] = ($ededuct['type'] === 'fixed')? $ededuct['deduct_value'] : round(($bsalary*$ededuct['deduct_value'])/100, 2);
    
            if($ed_id == 0){
                $ededuct['created_at'] = date('Y-m-d H:i:s', time());
                if(DB::table('employee_deductions')->insert($ededuct)){
                    return response()->json(array('status'=>true), 200);
                }else{
                    return response()->json(array('status'=>false), 200);
                }
            }else{
                $ededuct['updated_at'] = date('Y-m-d H:i:s', time());
                if(DB::table('employee_deductions')->where('id', $ed_id)->update($ededuct)){
                    return response()->json(array('status'=>true), 200);
                }else{
                    return response()->json(array('status'=>false), 200);
                }
            }
        }else{
            return response()->json(array('status'=>false), 200);
        }
    }
    public function delete_deduction(Request $request)
    {
        $status = false;
        $id = $request->post('id');
        
        if(!empty(DB::table('employee_deductions')->where('id', $id)->first())){
            $status = DB::table('employee_deductions')->where('id', $id)->delete();
        }
        return $status;
    }


    /* ========================================================================================================== */
    /* ========================================================================================================== */
    /* ========================================================================================================== */



    public function payout()
    {
        $data['months'] = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        return view('pages.payout')->with($data);
    }

    public function get_payroll(Request $request)
    {
        $month = $request->get('month');
        $year = $request->get('year');

        if($month!="" && $year!=""){
            $check_payslip = DB::table('monthly_payouts')->where([
                ['month', '=', $month],
                ['financial_year', '=', $year],
            ])->first();
            // dd($check_payslip->id);
            // exit;
            $data['month'] = $month;
            $data['year'] = $year;

            if(is_null($check_payslip)){
                $emps = DB::table('employee_salaries as es')
                    ->join('employees', 'es.emp_id', '=', 'employees.id')
                    ->select(DB::raw('es.*, employees.fullname, employees.emp_id as employee_id, (SELECT SUM(calc_earning) from employee_earnings ee where ee.emp_id = employees.id ) as earnings, (SELECT SUM(calc_deduct) from employee_deductions ee where ee.emp_id = employees.id ) as deductions'))
                    ->get();
                if(!empty($emps)){
                    $mpayout['month'] = $month;
                    $mpayout['financial_year'] = $year;
                    $mpayout['status'] = 'NOT_PROCESSED';
                    $mpayout['created_at'] = date('Y-m-d H:i:s', time());

                    $mp_id = DB::table('monthly_payouts')->insertGetId($mpayout);

                    $empayouts = array();
                    //employee_month_payouts

                    foreach($emps as $emp){
                        array_push($empayouts, array(
                            'mp_id' => $mp_id,
                            'emp_id' => $emp->emp_id,
                            'month' => $month,
                            'financial_year' => $year,
                            'basic' => $emp->basic_amount,
                            'earnings' => $emp->earnings,
                            'deductions' => $emp->deductions,
                            'payment_status' => 'UnPaid',
                            'created_at' => date('Y-m-d H:i:s', time())
                        ));
                    }
                    DB::table('employee_month_payouts')->insert($empayouts);
                }else{
                    return response()->json(array('message'=> 'Employees not added.'), 400);
                }   
            }
            $check_payslip = DB::table('monthly_payouts')->where([
                ['month', '=', $month],
                ['financial_year', '=', $year],
            ])->first();

            $data['mp_id'] = $check_payslip->id;
            $data['emps'] = DB::table('employee_month_payouts AS emp')
                ->join('employees', 'emp.emp_id', '=', 'employees.id')
                ->where('emp.mp_id', $data['mp_id'] )
                ->select(DB::raw('emp.*, employees.fullname, employees.emp_id as employee_id'))
                ->get();
            if($check_payslip->status === 'NOT_PROCESSED'){
                return view('pages.set_payslip')->with($data);
            }else{
                return view('pages.complete_payslip')->with($data);
            }
            
        }else{
            return response()->json(array('message'=> 'Must select month and year.'), 400);
        }
        
    }

    public function generate_payslip(Request $request)
    {
       /*
       array:16 [
        "mp_id" => "1"
        "empay_id" => array:2 [
            0 => "1"
            1 => "2"
        ]
        "basics_1" => "500"
        "earns_1" => "200"
        "deducts_1" => null
        "bonus_1" => null
        "commission_1" => null
        "reimburstment_1" => null
        "adjustment_1" => null
        "basics_2" => "1000"
        "earns_2" => "450"
        "deducts_2" => "175"
        "bonus_2" => null
        "commission_2" => null
        "reimburstment_2" => null
        "adjustment_2" => null
        ]
       */
        //initialize
        $basic = 0; $earns = 0; $deducts = 0; $bonus = 0; $commission = 0; $reimburstment = 0; $adjustment = 0;
        //------------
        $mp_id = $request->post('mp_id');
        $empay_ids = $request->post('empay_id');

        foreach($empay_ids as $emp){
            $net_salary = 0;
            $outflow = 0;
            $basic += $request->post('basics_'.$emp); 
            $earns += $request->post('earns_'.$emp); 
            $deducts += $request->post('deducts_'.$emp); 
            $bonus += $request->post('bonus_'.$emp); 
            $commission += $request->post('commission_'.$emp); 
            $reimburstment += $request->post('reimburstment_'.$emp); 
            $adjustment += $request->post('adjustment_'.$emp);

            $net_salary = ( $request->post('basics_'.$emp) + $request->post('earns_'.$emp) ) - $request->post('deducts_'.$emp); 
            $outflow = ($net_salary+$request->post('bonus_'.$emp)+$request->post('commission_'.$emp)+$request->post('reimburstment_'.$emp)) - $request->post('adjustment_'.$emp);
            DB::table('employee_month_payouts')->where('id', $emp)->update(array(
                'bonus'=>$request->post('bonus_'.$emp),
                'commision'=>$request->post('commission_'.$emp),
                'reimburstment'=>$request->post('reimburstment_'.$emp),
                'adjustment'=>$request->post('adjustment_'.$emp),
                'net_salary'=>$net_salary,
                'outflow'=>$outflow,
                'updated_at'=>date('Y-m-d H:i:s', time())
            ));
        }

        DB::table('monthly_payouts')->where('id', $mp_id)->update(array(
            'total_basic'=>$basic,
            'total_earnings'=>$earns,
            'total_deductions'=>$deducts,
            'total_bonus'=>$bonus,
            'total_commision'=>$commission,
            'total_reimburstment'=>$reimburstment,
            'total_adjustment'=>$adjustment,
            'net_salary'=>( ($basic + $earns) - $deducts),
            'total_outflow'=>( ($basic + $earns + $bonus + $commission + $reimburstment) - ($deducts + $adjustment)),
            'status'=>'PROCESSED_NOT_PAID',
            'updated_at'=>date('Y-m-d H:i:s', time()),

        ));

        return response()->json(array('status'=>true), 200);
    }

    public function give_payment(Request $request)
    {
        $status = false;
        $id = $request->id;
        if(DB::table('employee_month_payouts')->where('id', $id)->first()){
            $status = DB::table('employee_month_payouts')->where('id', $id)->update([
                'payment_status'=>'Paid',
                'salary_paid_at'=>date('Y-m-d H:i:s', time()),
                'updated_at'=>date('Y-m-d H:i:s', time())
            ]);
        }

        return response()->json(['status'=>$status], 200);
    }
    
}
