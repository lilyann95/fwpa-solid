<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<html>
    <head>
        <style>
            body {
                font-size: 12px;
            }
            table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            }

            .td-main, .th-main {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
            font-size: 8px !important;
            }

            .th-inside, .td-inside {
                text-align: left;
                padding: 2px;
                font-size: 8px !important;
            }

            .inside-row:nth-child(even) {
                background-color: whitesmoke;
            }
            .custom-td{
                white-space: break-spaces;
                width: 65%;
            }
        </style>
        <title>SAVINGS REPORT</title>
    </head>
    <body>
        <div style="display: flex;">
            <div class="col-5">
                <img src="images/logo.jpg" alt="NO IMAGE FOUND"  width="50" height="60" style="margin-left: auto; margin-right: auto;">
            </div>
            <br>
            <div class="col-7">
                <h4 style="text-align: center;">FWP SAVINGS FROM {{$year1}} TO {{ $year2 }} </h4>
               
                <h5 style="text-align: center;"> FOR: {{$name}} NO. {{$fwpnumber}}  </h5>
            </div>
        </div>
        @if (count($savings_collection)>0)
        <div class="year">
            <span style="float: right;">Total Contribution: 
                <strong>{{number_format($yearTotal, 2)}} UGX</strong>
            </span>
        </div>
        <br>
        <table>
            <thead>
                <tr>
                    <th class="th-main" scope="col">S/N</th>
                    <th class="th-main" scope="col">PAYMENT DATE</span></th>
                    <th class="th-main" scope="col">MONTHLY CONTRIBUTION</span></th>
                    <th scope="col" class="th-main">LATE PAYMENT</th>
                    <th scope="col" class="th-main">LATE MEETING</th>
                    <th scope="col" class="th-main">ABSENTEEISM</th>
                    <th scope="col" class="th-main">MARRIAGE</th>
                    <th scope="col" class="th-main">BIRTH</th>
                    <th scope="col" class="th-main">GRADUATION</th>
                    <th scope="col" class="th-main">CONSECRATION</th>
                    <th scope="col" class="th-main">SICKNESS</th>
                    <th scope="col" class="th-main">DEATH</th>
                    <th scope="col" class="th-main">TOTAL AMOUNT</th>
                    <th scope="col" class="th-main">DATE/TIME</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($savings_collection as $saving)
                    <tr>
                        <td class="th-main" scope="col">{{$loop->iteration}}</td>
                        <td class="th-main" scope="col">{{$saving->date}}</td>
                        <td class="th-main" scope="col">{{number_format($saving->monthly_contribution)}}</td>
                        <td scope="col" class="th-main">{{number_format($saving->late_payment)}}</td>
                        <td scope="col" class="th-main">{{number_format($saving->late_meeting)}}</td>
                        <td scope="col" class="th-main">{{number_format($saving->absenteeism)}}</td>
                        <td scope="col" class="th-main">{{number_format($saving->marriage)}}</td>
                        <td scope="col" class="th-main">{{number_format($saving->birth)}}</td>
                        <td scope="col" class="th-main">{{number_format($saving->graduation)}}</td>
                        <td scope="col" class="th-main">{{number_format($saving->consecration)}}</td>
                        <td scope="col" class="th-main">{{number_format($saving->sickness)}}</td>
                        <td scope="col" class="th-main">{{number_format($saving->death)}}</td>>
                        <td class="th-main" rowspan="1" scope="col">{{number_format($saving->total_amount)}}</td>
                        <td class="th-main" rowspan="1" scope="col">>{{$saving->created_at}}</td>
                    </tr> 
                @endforeach
            </tbody>
        </table>
        <div class="container">
         <br>
           <strong>Approved By</strong> 
            <br>
            <br>
            <br>
            <br>
            ................................ 
            <br>
            SECRETARY FOR FINANCE AND PROJECTS
        </div>
        @endif
    </body>
</html>