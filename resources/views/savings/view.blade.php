@section('dynamic-js')
    <script src="{{ asset('/dist/js/savings.js?v=134345')}}"></script>
@stop
@extends('layouts.app', ['noSideBar' => true])
@section('content')
    <div class="page-wrapper page">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-5">
                    <a href="{{ route('savings') }}" class="btn btn-outline-secondary btn-sm float-left mb-2" >
                        <i class="mdi mdi-arrow-left-bold"></i>
                            Return
                    </a>
                </div>
                <div class="col-6">
                    <div class="text-right upgrade-btn">
                        <a href="#" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#pdfsaving"><i class="fa fa-download" aria-hidden="true"></i> Download PDF</a>
                    </div>
                </div>   
            </div>
        </div>
        <br>
        <div class="container">
            <div class="align-items-center d-flex justify-content-center">
                <h4 class="page-title" style="font-size: 40px;">MEMBER SAVINGS STATUS</h4>
            </div>
            <form action="">
                <h4 class="font-20">Member<span class="text-danger">*</span></h4>
                <select class="browser-default custom-select" name="category" id="category">
                    <option selected disabled>Select member</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </form>
            <br>
            <label class="control-label font-20" for='year'> Year<span class="text-danger">*</span></label>
            <select name="subcategory" id="subcategory" class="form-control">
                <option value="" selected disabled>Select</option>
                <?php
                    $dates = range('2016', date('Y'));
                    foreach($dates as $date){
                        if (date('m', strtotime($date)) <= 6) {//Upto June
                            $year = ($date-1) . '-' . $date;
                        } else {//After June
                            $year = $date . '-' . ($date + 1);
                        }
                        echo "<option value='$year'>$year</option>";
                    }
                ?>
            </select>
        </div>
        <br>
             <br> 
        <div class="container">
        <div class="d-md-flex align-items-center">
             
            <br>
            <div>
                <h3 class="card-subtitle">Savings</h3>
                <h3>Total Contribution: <strong class="year-total">__ UGX</strong>,   
                Total Expenditure : <strong class="expenditure">__ UGX</strong> ,
                Amount Due: <strong class="amountdue">__ UGX</strong></h3>
            </div>
            
        </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <span class="connection-check text-danger ml-4" style="font-size: 12px;"></span>
                <!-- column -->
                    <div class="table table-striped table-responsive">
                        <table>
                            <col>
                            <colgroup span="3"></colgroup>
                            <colgroup span="7"></colgroup>
                            <tr class="bg-light">
                                <th class="border-top-0" rowspan="2" style="background-color: #b6fcd5"  scope="col">Month</th>
                                <th class="border-top-0" rowspan="2" style="background-color: #b6fcd5"  scope="col">Year</th>
                                <th class="border-top-0" rowspan="2" style="background-color: #b6fcd5"  scope="col">Monthly Contributions</th>
                                <th class="border-top-0" colspan="3" style="background-color: #b6fcd5"  scope="colgroup">Monthly Fines</th>
                                <th class="border-top-0" colspan="7" style="background-color: #b6fcd5"  scope="colgroup">Events</th>
                                <th class="border-top-0" id="total" rowspan="2" style="background-color: #b6fcd5"  scope="col">Total Amount Due</th>
                            </tr>
                            <tr>
                                <th class="border-top-0" style="background-color: #b6fcd5" scope="col">Late_Payment</th>
                                <th class="border-top-0" style="background-color: #b6fcd5" scope="col">Late_Meeting</th>
                                <th class="border-top-0" style="background-color: #b6fcd5" scope="col">Absenteeism</th>
                                <th class="border-top-0" style="background-color: #b6fcd5" scope="col">Marriage</th>
                                <th class="border-top-0" style="background-color: #b6fcd5" scope="col">Birth</th>
                                <th class="border-top-0" style="background-color: #b6fcd5" scope="col">Graduation</th>
                                <th class="border-top-0" style="background-color: #b6fcd5" scope="col">Consecretation</th>
                                <th class="border-top-0" style="background-color: #b6fcd5" scope="col">Sickness</th>
                                <th class="border-top-0" style="background-color: #b6fcd5" scope="col">Death</th>
                                <th class="border-top-0" style="background-color: #b6fcd5" scope="col">Loan Liability</th>
                            </tr> 
                            <tbody class="saving-tbody">
                            
                            <tr>
                                <th id="exp-btn" scope="row">BROUGHT FORWARD</th>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">JULY</th>
                                <td>10,000</td>
                                <td>5,000</td>
                                <td>12,000</td>
                                <td>9,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">AUGUST</th>
                                <td>10,000</td>
                                <td>5,000</td>
                                <td>12,000</td>
                                <td>9,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">SEPTEMBER</th>
                                <td>10,000</td>
                                <td>5,000</td>
                                <td>12,000</td>
                                <td>9,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">OCTOBER</th>
                                <td>10,000</td>
                                <td>5,000</td>
                                <td>12,000</td>
                                <td>9,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">NOVEMBER</th>
                                <td>10,000</td>
                                <td>5,000</td>
                                <td>12,000</td>
                                <td>9,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">DECEMBER</th>
                                <td>10,000</td>
                                <td>5,000</td>
                                <td>12,000</td>
                                <td>9,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">JANUARY</th>
                                <td>10,000</td>
                                <td>5,000</td>
                                <td>12,000</td>
                                <td>9,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">FEBRUARY</th>
                                <td>10,000</td>
                                <td>5,000</td>
                                <td>12,000</td>
                                <td>9,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">MARCH</th>
                                <td>10,000</td>
                                <td>5,000</td>
                                <td>12,000</td>
                                <td>9,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">APRIL</th>
                                <td>10,000</td>
                                <td>5,000</td>
                                <td>12,000</td>
                                <td>9,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">MAY</th>
                                <td>10,000</td>
                                <td>5,000</td>
                                <td>12,000</td>
                                <td>9,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">JUNE</th>
                                <td>10,000</td>
                                <td>5,000</td>
                                <td>12,000</td>
                                <td>9,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td>50,000</td>
                                <td>30,000</td>
                                <td>100,000</td>
                                <td>80,000</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">TOTAL</th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <!-- <tr>
                                <td class="border-top-0" rowspan="1" scope="row"><span class="font-14">TOTAL</span></td>
                            <tr> -->
                            </tbody>
                        </table>
                    </div>
                   
            </div>
        </div>
    </div>
@endsection