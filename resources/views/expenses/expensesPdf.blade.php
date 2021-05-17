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
        <title>EXPENSES REPORT</title>
    </head>
    <body>
        <div style="display: flex;">
            <div class="col-5">
                <img src="images/logo.jpg" alt="NO IMAGE FOUND"  width="50" height="60" style="margin-left: auto; margin-right: auto;">
            </div>
            <br>
            <div class="col-7">
                <h4 style="text-align: center;">FWP APPROVED EXPENSES FOR FOR {{$year1}} TO {{ $year2 }} </h4>
            </div>
        </div>
        @if (count($collection)>0)
            <div style="display: flex;">
                <div class="year">
                    <span style="float: right;">Total Expense: 
                        <strong>{{number_format($yearTotal, 2)}} UGX</strong>
                    </span>
                </div>
            </div>    
           <br>
            <table>
                <thead>
                    <tr>
                        <th scope="col" class="th-main">S/N</th>
                        <th scope="col" class="th-main" style="width: 60%;">DESCRIPTION</th>
                        <th scope="col" class="th-main">AMOUNT</th>
                        <th scope="col" class="th-main">PAYEE</th>
                        <th scope="col" class="th-main">DATE/TIME</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($collection as $expense)
                        <tr>
                            <td class="td-main">{{$loop->iteration}}</td>
                            <td class="td-main">
                                {{$expense->desc}}
                            </td>
                            <td class="td-main">{{number_format($expense->budget, 2)}}</td>
                            <td class="td-main">{{$expense->name}}</td>
                            <td class="td-main">{{$expense->created_at}}</td>
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