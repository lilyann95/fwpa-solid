{{--expenses request--}}
<div class="modal fade" id="expenses" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="expensesTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-14" id="expensesTitle">Request Expense</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="expense-form">
          @csrf
        <div class="modal-body">
          <div class="form-group">
              <label for="budget">Budget <span class="text-danger">*</span></label>
              <input type="number" class="form-control form-control-sm" required name="budget" id="budget" placeholder="Please input amount">
          </div>
          <div class="form-group">
              <label for="desc">Reason/Description <span class="text-danger">*</span></label>
              <textarea id="desc" name="desc" class="form-control form-control-sm" required maxlength="250" placeholder="Reason why your requesting" id="desc" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger btn-sm modal-close" data-dismiss="modal"><i class="mdi mdi-close-circle"></i> Close</button>
            <button type="submit" btn-id="" btn-action="save" id="request-btn" class="btn btn-outline-primary btn-sm"><i class="mdi mdi-check"></i> Request</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{--Loans request--}}
<div class="modal fade" id="loans" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loansTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" style="overflow-y: auto;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-14" id="loansTitle">Loan Application Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="loan-form">
          @csrf
          <div class="form-group font-20 col-9">
            <h4 class="font-20">Member' Name:</h4>
            <?php
              $users = DB::table("users")->where('id', '=', auth()->id())->get();
              foreach ($users as $user){ 
                $user= json_decode( json_encode($user), true);
                echo "<option value='".$user["id"]."'>".$user["fwpnumber"]."</option>";
              }
            ?>
          </div>
          <div class="form-group container font-20">
            <div class="d-md-flex align-items-center">
              <div class="col-4">
                  <label for="Amount-due">Total Amount Due </label>
                  <input type="number" class="form-control form-control-sm" name="total-amount" id="total-amount" readonly>
              </div>
              <div class="col-4">
                  <label for="expected_loan">75% Of Total Amount</label>
                  <input type="number" class="form-control form-control-sm" 
                    value="" 
                   required name="expected_loan" id="expected_loan" readonly>
              </div>
              <div class="col-4">
                  <label for="loan_limit">Loan Limit</label>
                  <input type="number" class="form-control form-control-sm" 
                    value="" 
                   required name="loan_limit" id="loan_limit" readonly>
              </div>
            </div>
          </div>
          <div class="form-group font-20 col-9">
            <label for="loan_amount">Loan Amount <span class="text-danger">*</span></label>
            <input type="number" class="form-control form-control-sm" required name="loan_amount" min="500000" 
              id="loan_amount" placeholder="please input amount">
          </div>
          <div class="resty lily">
            <div class="form-group font-20 col-9">
              <label class="font-20">Guarantor' Name<span class="text-danger">*</span></label>
              <select class="browser-default custom-select" name="submem" id="submem">
              <option selected disabled value="">Select Member</option>
                <?php
                  $defaulters = DB::table("loans")->where("loans.status", "=", "approved")->pluck('loans.user_id')->toArray();
                 
                  $users = DB::table("users")->where('id', '!=', auth()->id())->where("users.fwpnumber", "!=", "NONE_CP")->where("users.fwpnumber", "!=", "NONE_TR")->pluck("id")->toArray();
                  $missing = array_diff($users,$defaulters);
                  $usersmiss = array_values($missing);
                  $users2 = DB::table("users")->whereIn('id', $usersmiss)->get();
                  foreach($users2 as $miss) { 
                    $miss= json_decode( json_encode($miss), true);
                    echo "<option value='".$miss["id"]."'>".$miss["fwpnumber"]."</option>";
                  }  
                ?>  
              </select>
            </div>
            <div class="form-group container font-20">
              <div class="d-md-flex align-items-center">
                <div class="col-4">
                  <label for="Amount-due">Total Amount Due </label>
                  <input type="number" class="form-control form-control-sm" name="total-amount2" id="total-amount2" readonly>
                </div>
                <div class="col-4">
                  <label for="expected">Guarantor' Limit</label>
                  <input type="number" class="form-control form-control-sm" 
                    value="" 
                    required name="expected" id="expected" readonly>
                </div>
                <div class="col-4">
                  <label for="g_amount">Guarantor' Amount</label>
                  <input type="number" class="form-control form-control-sm" 
                    value="" 
                     name="g_amount" id="g_amount" >
                </div>
              </div>
            </div>
          </div>
          <div class="form-group font-20 col-9">
            <label for="fee">Processing Fee </label>
            <input type="number" class="form-control form-control-sm" required name="fee" id="fee" readonly>
          </div>
          <div class="form-group font-20 col-9">
            <label for="months_taken">Months Taken <span class="text-danger">*</span></label>
            <input type="number" class="form-control form-control-sm" min="1" max="3" required name="months_taken" id="months_taken">
          </div>
          <div class="form-group font-20 col-9">
            <label for="return">Expected Loan Return</span></label>
            <input type="number" class="form-control form-control-sm" required name="return" id="return" readonly>
          </div>
          <div class="form-group font-20">
            <label for="desc">Reason/Description <span class="text-danger">*</span></label>
            <textarea type="text" id="desc" name="desc" class="form-control form-control-sm desc" required maxlength="250" placeholder="Reason for requesting" id="desc" rows="3"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger btn-sm modal-close" data-dismiss="modal"><i class="mdi mdi-close-circle"></i> Close</button>
            <button type="submit" btn-id="" btn-action="save" id="loanrequest-btn" class="btn btn-outline-primary btn-sm"><i class="mdi mdi-check"></i> Request</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
{{-- reason for declinig a loan --}}
<div class="modal fade" id="declinereason" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loandeclineTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-14" id="loandeclineTitle">Reason for declining a loan</h5>
        <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="loanreason-form" method="POST">
          @csrf
        <div class="modal-body">
            <div class="form-group"> 
                <label for="desc">Reason<span class="text-danger">*</span></label>
                <textarea type="text" loan-id="" user="treasurer" name="reason" class="reason form-control form-control-sm" required maxlength="100" placeholder="please give a reason" id="deny-text" rows="2"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm modal-close" data-dismiss="modal"><i class="mdi mdi-close-circle"></i> Close</button>
            <button type="submit" class="btn btn-outline-danger btn-sm loandecliner"><i class="mdi mdi-block-helper"></i> Decline</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Updating the system with cleared loan --}}
<div class="modal fade" id="update" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="updateTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-14" id="updateTitle">Updating cleared loan</h5>
        <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="update-form" method="POST">
          @csrf
        <div class="modal-body">
            <div class="form-group">
              <label for="updatemonths_taken">Months Taken <span class="text-danger">*</span></label>
              <input type="number" class="form-control form-control-sm" min="1" max="3" name="updatemonths_taken" id="updatemonths_taken">
            </div>
            {{-- input to hold loan amount --}}
              <input type="hidden" class="form-control form-control-sm" name="update_loanamount" id="update_loanamount">
              <input type="hidden" class="form-control form-control-sm" name="update_lastpayment" id="update_lastpayment">
            
              <div class="form-group">
              <label for="update_return">Expected Loan Return</span></label>
              <input type="number" class="form-control form-control-sm" required name="update_return" id="update_return" readonly>
            </div>
            <div class="form-group noguar yesguar">
            
              <!-- <input type="hidden" name="seize[]" value="0"/>  -->
              <!-- <input type="checkbox" id="seize" name="seize" value="NO" > -->
              <!-- <input type="hidden" name="guarantor" class="guarantor"> -->
              <label for="seize">Seize Guarantor Portion</label> 
              <select name="seize" id="seize" value="seize">
                <option value="NO">NO</option>
                <option style="color: red; " value="YES">YES</option>
              </select>
              </div>
            </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm modal-close" data-dismiss="modal"><i class="mdi mdi-close-circle"></i> Close</button>
            <button type="submit" update-id="" user="treasurer" class="btn btn-outline-danger btn-sm loanupdater"><i class="ti-check color-success"></i> Clear</button>
           
          </div>
      </form>
    </div>
  </div>
</div>
{{-- Guarantor --}}
<div class="modal fade" id="guarantor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Guarantor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Loan Applicant</th>
              <th>Loan Amount</th>
              <th>Guarantor Amount</th>
              <th>Last Payment Date</th>
              <th>Date</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="guarantor"></tbody>
        </table>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
{{-- pdf Loans --}}
<div class="modal fade" id="loanpdf" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loanpdfTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-14" id="loanpdfTitle">Download</h5>
        <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('loanpdf')}}" method="POST">
          @csrf
        <div class="modal-body">
          
            <div class="form-group ml-auto">
                <label for="date">Start Date <span class="text-danger">*</span></label>
                <input id="date1" required name="month1" value="" class="form-control form-contol-sm" type="date" placeholder="Select Date"  >
            </div>
            <div class="form-group ml-auto">
                <label for="date">End Date <span class="text-danger">*</span></label>
                <input id="date2" required name="month2" value=""  class="form-control form-contol-sm" type="date" placeholder="Select Date"  >
            </div>
            {{-- <div class="form-group">
                <label for="Year">Select Year <span class="text-danger">*</span></label>
                <input required name="year"  class="form-control form-contol-sm" type="text" placeholder="Select Year"  id="pdf-year">
            </div> --}}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm modal-close" data-dismiss="modal"><i class="mdi mdi-close-circle"></i> Close</button>
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-eye" aria-hidden="true"></i> View</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- pdf Approved Loans --}}
<div class="modal fade" id="approvedloans" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="approvedpdfTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-14" id="approvedpdfTitle">Download Approved Loans</h5>
        <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('Approvedloanpdf')}}" method="POST">
          @csrf
        <div class="modal-body">
          
            <div class="form-group ml-auto">
                <label for="date">Start Date <span class="text-danger">*</span></label>
                <input id="date1" required name="date1" value="" class="form-control form-contol-sm" type="date" placeholder="Select Date"  >
            </div>
            <div class="form-group ml-auto">
                <label for="date">End Date <span class="text-danger">*</span></label>
                <input id="date2" required name="date2" value=""  class="form-control form-contol-sm" type="date" placeholder="Select Date"  >
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm modal-close" data-dismiss="modal"><i class="mdi mdi-close-circle"></i> Close</button>
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-eye" aria-hidden="true"></i> View</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- pdf Expenses --}}
<div class="modal fade" id="pdf" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="pdfTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-14" id="pdfTitle">Download</h5>
        <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('pdf')}}" method="POST">
          @csrf
        <div class="modal-body">
            <div class="form-group ml-auto">
                <label for="date">Start Date <span class="text-danger">*</span></label>
                <input id="date1" required name="month1" value="" class="form-control form-contol-sm" type="date" placeholder="Select Date"  >
            </div>
            <div class="form-group ml-auto">
                <label for="date">End Date <span class="text-danger">*</span></label>
                <input id="date2" required name="month2" value=""  class="form-control form-contol-sm" type="date" placeholder="Select Date"  >
            </div>
           
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm modal-close" data-dismiss="modal"><i class="mdi mdi-close-circle"></i> Close</button>
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-eye" aria-hidden="true"></i> View</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- pdf Savings --}}
<div class="modal fade" id="pdfsaving" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="pdfTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-14" id="pdfTitle">Download</h5>
        <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('pdfsaving')}}" method="POST">
          @csrf
        <div class="modal-body">
          <div class="form-group font-20">
            <h4 class="font-20">Member<span class="text-danger">*</span></h4>
            <select class="browser-default custom-select" name="cate" id="cate">
            <option selected disabled value="">Select Member</option>
              <?php
                $users = DB::table("users")->where("users.fwpnumber", "!=", "NONE_CP")->where("users.fwpnumber", "!=", "NONE_TR")->get();
                foreach ($users as $user){ 
                  $user= json_decode( json_encode($user), true);
                  echo "<option value='".$user["id"]."'>".$user["fwpnumber"]."</option>";
                }
              ?>
           </select>
          </div>
          <br>
          <div class="nopdfname yespdfname">
                <div class="align-items-center d-flex justify-content-center">
                    <input name="fwpnamemodal" class="fwpnamemodal" type="text">
                </div>
            </div>
          <div class="form-group ml-auto">
              <label for="date">Start Date <span class="text-danger">*</span></label>
              <input id="date1" required name="month1" value="" class="form-control form-contol-sm" type="date" placeholder="Select Date"  >
          </div>
          <div class="form-group ml-auto">
              <label for="date">End Date <span class="text-danger">*</span></label>
              <input id="date2" required name="month2" value=""  class="form-control form-contol-sm" type="date" placeholder="Select Date"  >
          </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm modal-close" data-dismiss="modal"><i class="mdi mdi-close-circle"></i> Close</button>
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-eye" aria-hidden="true"></i> View</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- reason for declinig expense --}}
<div class="modal fade" id="reason" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="reasonTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-14" id="reasonTitle">Reason for declining expense</h5>
        <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="reason-form" method="POST">
          @csrf
        <div class="modal-body">
            <div class="form-group"> 
                <label for="desc">Reason<span class="text-danger">*</span></label>
                <textarea exp-id="" user="treasurer" name="reason" class="form-control form-control-sm" required maxlength="100" placeholder="Reason why" id="reason-text" rows="2"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm modal-close" data-dismiss="modal"><i class="mdi mdi-close-circle"></i> Close</button>
            <button type="submit" class="btn btn-outline-danger btn-sm decliner"><i class="mdi mdi-block-helper"></i> Decline</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- member's perfomance --}}
<div class="modal fade" id="savings" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="savingsTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-24" id="savingsTitle">Member's Performance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>     
      <div class="modal-body">
        <form id="savings-form" method="POST">
          @csrf
          <div class="form-group font-20">
          <h4 class="font-20">Member<span class="text-danger">*</span></h4>
          <select class="browser-default custom-select" name="savingscate" id="savingscate">
          <option selected disabled value="">Select Member</option>
            <?php
              $users = DB::table("users")->where("users.fwpnumber", "!=", "NONE_CP")->where("users.fwpnumber", "!=", "NONE_TR")->get();
              foreach ($users as $user){ 
                $user= json_decode( json_encode($user), true);
                echo "<option value='".$user["id"]."'>".$user["fwpnumber"]."</option>";
              }
            ?>
           </select>
          </div>
          <div class="nomembername yesmembername">
              <div class="align-items-center d-flex justify-content-center">
                  <input name="fwpmembername" class="fwpmembername" type="text">
              </div>
          </div>
          <!-- <br>  -->
          <div class="form-group">
            <label for="monthly_contribution">Contribution<span class="text-danger">*</span></label>
            <input type="number" class="form-control" required name="monthly_contribution" id="monthly_contribution" placeholder="00">
          </div>
          <div class="ml-auto">
              <label>Month</label>
              <input class="form-control monthpayment" id="late" max="<?php echo date("Y-m-d");?>" type="date" value="" name="month" /> 
          </div>
          <hr class="my-3">
            <!-- Heading -->
          <h5 class="modal-heading font-20 p-0">
            <span class="docs-normal">Fines</span>
          </h5>
          <div class="form-group">
            {{-- input to hold user arreas --}}
            <input type="hidden" name="arreas-holder" class="arreas-holder">
            <label for="late_payment">Late Payment</label>
            <input type="number" class="form-control qty" required name="late_payment" id="late_payment" value="0" placeholder="00">
          </div>
          <div class="form-group">
            <label for="late_meeting">Late for meetings</label>
            <input type="number" class="form-control qty" required name="late_meeting" id="late_meeting" value="0" placeholder="00">
          </div>
          <div class="form-group">
            <label for="absenteeism">Absenteeism</label>
            <input type="number" class="form-control qty" required name="absenteeism" id="absenteeism" value="0" placeholder="00">
          </div>
          <hr class="my-3">
            <!-- Heading -->
          <h5 class="modal-heading p-0 font-20">
            <span class="docs-normal">Events</span>
          </h5>
          <div class="form-group">
            <label for="marriage">Marriage</label>
            <input type="number" class="form-control qty" required name="marriage" id="marriage" value="0" placeholder="00">
          </div>
          <div class="form-group">
            <label for="birth">Birth</label>
            <input type="number" class="form-control qty" required name="birth" id="birth" placeholder="00" value="0">
          </div>
          <div class="form-group">
            <label for="graduation">Graduation</label>
            <input type="number" class="form-control qty" required name="graduation" id="graduation" value="0" placeholder="00">
          </div>
          <div class="form-group">
            <label for="consecration">Consecration</label>
            <input type="number" class="form-control qty" required name="consecration" id="consecration" value="0" placeholder="00">
          </div>
          <div class="form-group">
            <label for="sickness">Sickness</label>
            <input type="number" class="form-control qty" required name="sickness" id="sickness" value="0" placeholder="00">
          </div>
          <div class="form-group">
            <label for="death">Death</label>
            <input type="number" class="form-control qty" required name="death" id="death" value="0" placeholder="00">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger btn-sm modal-close" data-dismiss="modal"><i class="mdi mdi-close-circle"></i> Close</button>
            <button type="submit" btn-id="" btn-action="save" id="save-btn" class="btn btn-outline-primary btn-sm"><i class="mdi mdi-check"></i> Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
{{-- member's pay out --}}
<div class="modal" id="payout" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-14">Pay out</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('pdf')}}" method="POST">
          @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="Year">Select Member <span class="text-danger">*</span></label>
                <input required name="member"  class="form-control form-contol-sm" type="text" placeholder="Select Member"  id="pdf-year">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm modal-close" data-dismiss="modal"><i class="mdi mdi-close-circle"></i> Close</button>
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="" aria-hidden="true"></i> View</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- Deleting modal alert for loans --}}
<div class="modal" id="delete-alert-loans" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white font-14">CONFIRM PLEASE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="form-group text-center">
              <h2 class="text-danger"><i class="fa fa-exclamation" aria-hidden="true"></i></h2>
              <h2 class="text-danger">Are You sure you want to delete this loan request !</h2>
              <strong>This is a permanet action.</strong>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm modal-close" data-dismiss="modal"><i class="mdi mdi-close-circle"></i> Close</button>
            <button type="submit" class="btn btn-outline-danger btn-sm" id="deleteloan-confirm" id-data=""><i class="fa fa-trash" aria-hidden="true"></i> Confirm Delete</button>
        </div>
    </div>
  </div>
</div>

{{-- Deleting modal alert for expenses --}}
<div class="modal" id="delete-alert-expenses" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white font-14">CONFIRM PLEASE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="form-group text-center">
              <h2 class="text-danger"><i class="fa fa-exclamation" aria-hidden="true"></i></h2>
              <h2 class="text-danger">Are You sure you want to delete this expense request !</h2>
              <strong>This is a permanet action.</strong>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm modal-close" data-dismiss="modal"><i class="mdi mdi-close-circle"></i> Close</button>
            <button type="submit" class="btn btn-outline-danger btn-sm" id="deleteExpense-confirm" id-data=""><i class="fa fa-trash" aria-hidden="true"></i> Confirm Delete</button>
        </div>
    </div>
  </div>
</div>
