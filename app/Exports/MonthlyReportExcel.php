<?php

namespace App\Exports;

use App\Models\Maintenance;
use App\Models\MonthlyReport;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class MonthlyReportExcel implements FromView,WithStyles
{
   public function __construct( public array $request)
   {
   }

    public function view(): View
    {
        $items =  MonthlyReport::whereMonth('date',(int) $this->request['month'])->whereYear('date',(int) $this->request['year'])->orderBy('date')->get()->groupBy('car_id');
        return view('pdf.report.monthlyReportExcel',['items'=>$items,'date'=>strtoupper($this->request['data'])]);
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:C1')->getFont()->setSize(8);
        $sheet->getStyle('A2:H3')->getFont()->setSize(20)->setBold(true)->setUnderline(true);

        $sheet->getStyle('A5:Z1000')->getFont()->setSize(12);
        foreach(range('A','I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        $sheet->getRowDimension(1)->setRowHeight(60);
    }
}
