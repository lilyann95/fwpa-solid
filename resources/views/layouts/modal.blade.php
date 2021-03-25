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
              <input type="number" class="form-control form-control-sm" required name="budget" id="budget" placeholder="2000000">
          </div>
          <div class="form-group">
              <label for="desc">Reason/Description <span class="text-danger">*</span></label>
              <textarea id="desc" name="desc" class="form-control form-control-sm" required maxlength="250" placeholder="Reason why your requesting" id="desc" rows="3"></textarea>
          </div>
          <div class="form-group">
              <label for="months_taken">Months taken <span class="text-danger">*</span></label>
              <input type="number" class="form-control form-control-sm" required name="months_taken" id="months_taken" placeholder="00">
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
{{-- pdf 1 --}}
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
            <div class="form-group">
                <label for="Year">Select Year <span class="text-danger">*</span></label>
                <input required name="year"  class="form-control form-contol-sm" type="text" placeholder="Select Year"  id="pdf-year">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm modal-close" data-dismiss="modal"><i class="mdi mdi-close-circle"></i> Close</button>
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fa fa-download" aria-hidden="true"></i> Download</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- pdf 2 --}}
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
            <div class="form-group">
              <label class="control-label font-20" > Year<span class="text-danger">*</span></label>
              <select name="subcategory" id="subcategory" class="form-control">
                  <option value="" selected disabled></option>
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
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm modal-close" data-dismiss="modal"><i class="mdi mdi-close-circle"></i> Close</button>
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fa fa-download" aria-hidden="true"></i> Download</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- reason for declinig dexpense --}}
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
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
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
          <select class="browser-default custom-select" name="cate" id="cate">
          <option ></option>
            <?php
              $users = DB::table("users")->get("users.name");
              foreach ($users as $user){ 
                $user= implode(json_decode( json_encode($user), true));
                echo "<option value='$user'>$user</option>";
              }
            ?>
           </select>
          </div>
          <br> 
          <div class="form-group">
            <label for="monthly_contribution">Monthly contribution<span class="text-danger">*</span></label>
            <input type="number" class="form-control qty" required name="monthly_contribution" id="monthly_contribution" placeholder="80000">
          </div>
          <hr class="my-3">
            <!-- Heading -->
          <h5 class="modal-heading font-20 p-0">
            <span class="docs-normal">Fines</span>
          </h5>
          <div class="form-group">
            <label for="late_payment">Late Payment</label>
            <input type="number" class="form-control qty" required name="late_payment" id="late_payment" placeholder="2000">
          </div>
          <div class="form-group">
            <label for="late_meeting">Late for meetings</label>
            <input type="number" class="form-control qty" required name="late_meeting" id="late_meeting" placeholder="2000">
          </div>
          <div class="form-group">
            <label for="absenteeism">Absenteeism</label>
            <input type="number" class="form-control qty" required name="absenteeism" id="absenteeism" placeholder="2000">
          </div>
          <hr class="my-3">
            <!-- Heading -->
          <h5 class="modal-heading p-0 font-20">
            <span class="docs-normal">Events</span>
          </h5>
          <div class="form-group">
            <label for="marriage">Marriage</label>
            <input type="number" class="form-control qty" required name="marriage" id="marriage" placeholder="2000">
          </div>
          <div class="form-group">
            <label for="birth">Birth</label>
            <input type="number" class="form-control qty" required name="birth" id="birth" placeholder="2000">
          </div>
          <div class="form-group">
            <label for="graduation">Graduation</label>
            <input type="number" class="form-control qty" required name="graduation" id="graduation" placeholder="2000">
          </div>
          <div class="form-group">
            <label for="consecration">Consecration</label>
            <input type="number" class="form-control qty" required name="consecration" id="consecration" placeholder="2000">
          </div>
          <div class="form-group">
            <label for="sickness">Sickness</label>
            <input type="number" class="form-control qty" required name="sickness" id="sickness" placeholder="2000">
          </div>
          <div class="form-group">
            <label for="death">Death</label>
            <input type="number" class="form-control qty" required name="death" id="death" placeholder="2000">
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
