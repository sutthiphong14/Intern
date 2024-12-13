<?php

namespace App\Exports;

use App\Models\Exportinstllfttx;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ExportFttxReport implements FromView
{
    /**
    * @return 
    */

    public function view(): View
    {
        return view('report.export', [
            'data' => Exportinstllfttx::all(),
            // 'isExport' => true // กำหนดว่าเป็น Export View
        ]);
    }
}
