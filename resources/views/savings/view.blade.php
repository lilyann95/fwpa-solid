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
                        <a href="#" data-toggle="modal" data-target="#pdfsaving"><i class="fas fa-eye fa-3x" title="VIEW MEMBER'S SAVINGS"></i></a>
                    </div>
                </div>   
            </div>
        </div>
        <br>
        <div class="container">
            <div class="align-items-center d-flex justify-content-center">
                <h4 class="page-title" style="font-size: 40px; color: #ff8533">MEMBER SAVINGS STATUS</h4>
            </div>
            <form action="">
                <h4 class="font-20">Member<span class="text-danger">*</span></h4>
                <select class="browser-default custom-select" name="category" id="category">
                    <option selected disabled>Select member</option>
                    @foreach ($data["users"] as $user)
                        <option value="{{ $user->id }}">{{ $user->fwpnumber }}</option>
                        
                    @endforeach
                </select>
            </form>
            <br>
            <div class="noname yesname">
                <div class="align-items-center d-flex justify-content-center">
                    <input class="fwpname" type="text">
                </div>
            </div>
            
            <br>
            
            <br>
            <label class="control-label font-20" for='year'> Year<span class="text-danger">*</span></label>
            <select name="subcategory" id="subcategory" class="form-control subcategory">
                <option value="" selected disabled>Select</option>
                <?php
                    $dates = range('2019', date('Y'));
                    foreach($dates as $date){
                        if (date('m', strtotime($date)) <= 6) {//Upto June
                            $year = '2018' . '-' . $date;
                        } else {//After June
                            $year = '2018' . '-' . ($date + 1);
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
            <div class="col-md-6">
                <h3 class="card-subtitle"><strong> SAVINGS </strong></h3>
                {{-- getting the total contribution --}}
                @php
                    $totalContrb = 0;
                    foreach ($data["savings"] as $saving)
                        $totalContrb += $saving->monthly_contribution
                @endphp
                <h3 >Total Contribution: <strong class="year-total float-right">{{ number_format($totalContrb) }} UGX</strong></h3> 
                <h3 >Savings Expenditure : <strong class="expenditure float-right">{{ number_format($data["expendit"]) }} UGX</strong></h3>
                <h3 >Running Loan : <strong class="loan float-right">{{ number_format($data["loan"]) }} UGX</strong></h3>
                <h3 >Expected Loan Return : <strong class="loanreturn float-right">{{ number_format($data["loanreturn"]) }} UGX</strong></h3>
                <h3 >Current Balance: <strong class="amountdue float-right">{{ number_format($data["amount"]) }} UGX</strong></h3>
            </div> 
            <!-- <br>
            <br> -->
            <div class="col-md-6 nopayout yespayout">
               
                <h3><strong> PAYOUT </strong></h3>
                <h3 class="">Expected Savings: <strong class="Expected-savings float-right">{{ number_format($data["Expected"]) }} UGX</strong></h3> 
                 
                <h3 class="">90% Of Expected Savings : <strong class="percent float-right">{{ number_format($data["percent"]) }} UGX</strong></h3>
                <h3 class="">Arrears : <strong class="Arrears float-right">{{ number_format($data["Arrears"]) }} UGX</strong></h3>
                <h3 class="">Payout Amount: <strong class="payout float-right">{{ number_format($data["Payout"]) }} UGX</strong></h3>
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
                                <th class="border-top-0" rowspan="2" style="background-color: #ff8533"  scope="col">Month</th>
                                <th class="border-top-0" rowspan="2" style="background-color: #ff8533"  scope="col">Year</th>
                                <th class="border-top-0" rowspan="2" style="background-color: #ff8533"  scope="col">Monthly Contributions</th>
                                <th class="border-top-0" colspan="3" style="background-color: #ff8533"  scope="colgroup">Monthly Fines</th>
                                <th class="border-top-0" colspan="6" style="background-color: #ff8533"  scope="colgroup">Events</th>
                            </tr>
                            <tr>
                                <th class="border-top-0" style="background-color: #ff8533" scope="col">Late_Payment</th>
                                <th class="border-top-0" style="background-color: #ff8533" scope="col">Late_Meeting</th>
                                <th class="border-top-0" style="background-color: #ff8533" scope="col">Absenteeism</th>
                                <th class="border-top-0" style="background-color: #ff8533" scope="col">Marriage</th>
                                <th class="border-top-0" style="background-color: #ff8533" scope="col">Birth</th>
                                <th class="border-top-0" style="background-color: #ff8533" scope="col">Graduation</th>
                                <th class="border-top-0" style="background-color: #ff8533" scope="col">Consecration</th>
                                <th class="border-top-0" style="background-color: #ff8533" scope="col">Sickness</th>
                                <th class="border-top-0" style="background-color: #ff8533" scope="col">Death</th>
                            </tr> 
                            <tbody class="saving-tbody">
                            @foreach ($data["savings"] as $saving)
                            <tr>
                                <th scope="row">{{date('M',strtotime($saving->date))}}</th>
                                <td>{{date('Y',strtotime($saving->date))}}</td>
                                <td>{{ number_format($saving->monthly_contribution) }}</td>
                                <td>{{ number_format($saving->late_payment) }}</td>
                                <td>{{ number_format($saving->late_meeting) }}</td>
                                <td>{{ number_format($saving->absenteeism) }}</td>
                                <td>{{ number_format($saving->marriage )}}</td>
                                <td>{{ number_format($saving->birth) }}</td>
                                <td>{{ number_format($saving->graduation) }}</td>
                                <td>{{ number_format($saving->consecration) }}</td>
                                <td>{{ number_format($saving->sickness) }}</td>
                                <td>{{ number_format($saving->death) }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                
            </div>
        </div>
    </div>
@endsection