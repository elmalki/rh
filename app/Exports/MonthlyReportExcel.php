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
    public $n_operations = 0;
    public $n_cars = 0;
   public function __construct( public array $request)
   {
   }

    public function view(): View
    {

        $items = MonthlyReport::whereMonth('date',(int) $this->request['month'])->whereYear('date',(int) $this->request['year'])->orderBy('date')->get();
        $this->n_operations = $items->count();
        $this->n_cars = $items->unique('car_id')->count();
        $items =  $items->groupBy('car_id');
        return view('pdf.report.monthlyReportExcel',['items'=>$items,'date'=>strtoupper($this->request['data'])]);
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H300')->applyFromArray([
            'font' => [
                'name' => 'Aptos Narrow',
            ]
        ]);
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(18.70);
        $sheet->getColumnDimension('C')->setWidth(11.80);
        $sheet->getColumnDimension('D')->setWidth(11.80);
        $sheet->getColumnDimension('E')->setWidth(11.80);
        $sheet->getColumnDimension('F')->setWidth(13);
        $sheet->getColumnDimension('G')->setWidth(11.80);
        $sheet->getColumnDimension('H')->setWidth(31);
        $total_lines = $this->n_operations+$this->n_cars*3+21;
        $sheet->getPageSetup()->setPrintArea('A1:H'.$total_lines);

        // Page orientation and size
        $sheet->getPageSetup()
            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT)
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

        // Repeat rows at top of each page
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

        // Margins (in inches)
        $sheet->getPageMargins()
            ->setTop(0.2)
            ->setRight(0.2)
            ->setLeft(0.2)
            ->setBottom(0.2);

        // Center horizontally
        $sheet->getPageSetup()->setHorizontalCentered(true);
        $sheet->getStyle('A:H')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:C1')->getFont()->setSize(12);
        $sheet->getStyle('A2:H3')->getFont()->setSize(20)->setBold(true)->setUnderline(true);

        $sheet->getStyle('A4:Z1000')->getFont()->setSize(14);

        $sheet->getRowDimension(1)->setRowHeight(100);
        $sheet->getRowDimension(3)->setRowHeight(50);

    }
}
