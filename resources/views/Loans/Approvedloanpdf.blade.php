<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<html>
    <head>
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/logo.jpg')}}"> -->
    <!-- <title>Friends With a Purpose</title> -->
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
          
            /* .resty {
                margin-left: auto;
                margin-right: auto;
            } */
        </style>
        <title>APPROVED LOANS REPORT</title>
    </head>
    <body>
        <div style="display: flex;">
            <div class="col-5">
                <img src="images/logo.jpg" alt="NO IMAGE FOUND"  width="50" height="60" style="margin-left: auto; margin-right: auto;">
            </div>
            <br>
            <div class="col-7">
                <h4 style="text-align: center;">FWP APPROVED LOANS FOR {{$year1}} TO {{ $year2 }} </h4>
            </div>
        </div>
        @if (count($loan_collection)>0)
        <div style="display: flex;">
            <div class="year col-6">
                <div>
                    <span style="float: left;"> Total Loan Return: 
                        <strong>{{number_format($yearTotal, 2)}} UGX</strong>
                    </span>
                    <span style="float: right;"> Total Profit: 
                        <strong>{{number_format($profityear, 2)}} UGX</strong>
                    </span>
                </div>
                <br>
            </div>
        </div>
            <table>
                <thead>
                    <tr>
                        <th scope="col" class="th-main">S/N</th>
                        <th scope="col" class="th-main" style="width: 40%;">DESCRIPTION</th>
                        <th scope="col" class="th-main">LOAN AMOUNT</th>
                        <th scope="col" class="th-main">MONTHS TAKEN</th>
                        <th scope="col" class="th-main">PROCESSING FEE</th>
                        <th scope="col" class="th-main">LOAN RETURN</th>
                        <th scope="col" class="th-main">GUARANTOR</th>
                        <th scope="col" class="th-main">GUARANTOR AMOUNT</th>
                        <th scope="col" class="th-main">PAYEE NAME</th>
                        <th scope="col" class="th-main">PAYEE NUMBER</th>
                        <th scope="col" class="th-main">DATE/TIME</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loan_collection as $loan)
                        <tr>
                            <td class="td-main">{{$loop->iteration}}</td>
                            <td class="td-main">
                                {{$loan->desc}}
                            </td>
                            <td class="td-main">{{number_format($loan->loanamount, 2)}}</td>
                            <td class="td-main">{{$loan->monthstaken}}</td>
                            <td class="td-main">{{$loan->processingfee}}</td>
                            <td class="td-main">{{number_format($loan->return, 2)}}</td>
                            <td class="td-main">{{$loan->quarantor}}</td>
                            <td class="td-main">{{number_format($loan->g_amount, 2)}}</td>
                            <td class="td-main">{{$loan->name}}</td>
                            <td class="td-main">{{$loan->fwpnumber}}</td>
                            <td class="td-main">{{$loan->created_at}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="container">
                <br>
                Approved By
                <br>
                <br>
                <br>
                <br>
                ................................. 
                <br>
                SECRETARY FOR FINANCE AND PROJECTS
            </div>
        @endif
    </body>
</html>