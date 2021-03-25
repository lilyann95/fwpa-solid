<?php

namespace App\Exports;

use App\Savings;
use Maatwebsite\Excel\Concerns\FromCollection;

class SavingsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Savings::all();
    }
}
