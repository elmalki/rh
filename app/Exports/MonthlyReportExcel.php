<?php

namespace App\Exports;

use App\Models\Maintenance;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class MonthlyReportExcel implements FromView,WithStyles
{
   public function __construct(public Collection $items,public String $date)
   {
   }

    public function view(): View
    {
        return view('pdf.report.monthlyReportExcel',['items'=>$this->items,'date'=>$this->date]);
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:C1')->getFont()->setSize(11);
        $sheet->getStyle('A2:H2')->getFont()->setSize(18)->setBold(true)->setUnderline(true);

        $sheet->getStyle('A4:Z1000')->getFont()->setSize(14);
        foreach(range('A','I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        $sheet->getRowDimension(1)->setRowHeight(60);
    }
}
