<?php

namespace App\Exports;

use App\Models\Car;
use App\Models\Deplacement;
use App\Models\Maintenance;
use App\Models\MonthlyReport;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class CarnetDeBordExcel implements FromView,WithStyles
{
    public $n_items = 0;
    public $n_cars = 0;
    public function __construct( public array $request)
    {
    }

    public function view(): View
    {
        $items = Deplacement::where('car_id',$this->request['car_id'])->whereMonth('date',(int) $this->request['month'])->whereYear('date',(int) $this->request['year'])->orderBy('date')->get();
        $this->n_items = $items->count();
        return view('pdf.report.carnetDeBordExcel',['car'=>Car::find($this->request['car_id']),'items'=>$items,'date'=>strtoupper($this->request['data'])]);
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G300')->applyFromArray([
            'font' => [
                'name' => 'Aptos Narrow',
            ]
        ]);
        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(14.70);
        $sheet->getColumnDimension('C')->setWidth(14.70);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(24);
        $sheet->getColumnDimension('G')->setWidth(24);
        $total_lines = $this->n_items+10;
        $sheet->getPageSetup()->setPrintArea('A1:G'.$total_lines);

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
        $sheet->getStyle('A:G')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:C1')->getFont()->setSize(12);
        $sheet->getStyle('A2:G3')->getFont()->setSize(20)->setBold(true)->setUnderline(true);

        $sheet->getStyle('A4:Z100')->getFont()->setSize(14);

        $sheet->getRowDimension(1)->setRowHeight(100);
        $sheet->getRowDimension(3)->setRowHeight(50);
        for($i=0;$i<$this->n_items;$i++)
             $sheet->getRowDimension(6+$i)->setRowHeight(30);
    }
}
