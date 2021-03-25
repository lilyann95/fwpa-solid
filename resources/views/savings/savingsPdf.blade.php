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
    </head>
    <body>
        @if (count($collection)>0)
        <div class="year">
            <span style="float: right;">{{$dates}} Total Expense: 
                <strong>{{number_format($yearTotal, 2)}} UGX</strong>
            </span>
        </div>
            @foreach ($collection as $savings)
                    <div style="margin-bottom: 5px; margin-top: 20px;">
                        <span>Savings for
                            <strong>
                                @if ($savings->month)
                                    @switch($savings->month)
                                        @case("01")
                                            January
                                            @break
                                        @case("02")
                                            Febrary
                                            @break
                                        @case("03")
                                            March
                                            @break
                                        @case("04")
                                            April
                                            @break
                                        @case("05")
                                            May
                                            @break
                                        @case("06")
                                            June
                                            @break
                                        @case("07")
                                            Jully
                                            @break
                                        @case("08")
                                            August
                                            @break
                                        @case("09")
                                            September
                                            @break
                                        @case("10")
                                            October
                                            @break
                                        @case("11")
                                            November
                                            @break
                                        @case("12")
                                            December
                                            @break
                                        @default
                                            @break
                                    @endswitch
                                    : {{number_format($savings->monthTotal, 2)}} UGX
                                @endif
                            </strong>
                        </span>
                        <br>
                    </div>
                <table>
                    <thead>
                        <tr>
                            <th scope="col" class="th-main" style="width: 60%;">DESCRIPTION</th>
                            <th scope="col" class="th-main">AMOUNT</th>
                            <th scope="col" class="th-main">PAYEE</th>
                            <th scope="col" class="th-main">DATE/TIME</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($savings->savings as $saving)
                            <tr>
                            <td class="border-top-0" rowspan="1" scope="col"><span class="font-14"></span></td>
                                <td class="border-top-0" rowspan="1" scope="col"><span class="font-14">Payee</span></td>
                                <td class="border-top-0" rowspan="1" scope="col"><span class="font-14">monthly_contribution</span></td>
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
                            <tr>
                                <td class="border-top-0" rowspan="1" scope="col"><span class="font-14">{{$saving->month}}</span></td>
                                <td class="border-top-0" rowspan="1" scope="col"><span class="font-14">{{$saving->name}}</span></td>
                                <td class="border-top-0" rowspan="1" scope="col"><span class="font-14">{{number_format($saving->monthly_contribution)}}</span></td>
                                <td class="border-top-0" scope="col"><span class="font-14">{{number_format($saving->late_payment)}}</span></td>
                                <td class="border-top-0" scope="col"><span class="font-14">{{number_format($saving->late_meeting)}}</span></td>
                                <td class="border-top-0" scope="col"><span class="font-14">{{number_format($saving->absenteeism)}}</span></td>
                                <td class="border-top-0" scope="col"><span class="font-14">{{number_format($saving->marriage)}}</span></td>
                                <td class="border-top-0" scope="col"><span class="font-14">{{number_format($saving->birth)}}</span></td>
                                <td class="border-top-0" scope="col"><span class="font-14">{{number_format($saving->graduation)}}</span></td>
                                <td class="border-top-0" scope="col"><span class="font-14">{{number_format($saving->consecration)}}</span></td>
                                <td class="border-top-0" scope="col"><span class="font-14">{{number_format($saving->sickness)}}</span></td>
                                <td class="border-top-0" scope="col"><span class="font-14">{{number_format($saving->death)}}</span></td>
                                <td class="border-top-0" scope="col"><span class="font-14">{{number_format($saving->loan_liability)}}</span></td>
                                <td class="border-top-0" rowspan="1" scope="col"><span class="font-14">{{number_format($saving->total_amount)}}</span></td>
                                <td class="border-top-0" rowspan="1" scope="col"><span class="font-14">{{$saving->created_at}}</span></td>
                            </tr> 
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        @endif
    </body>
</html>