<?php

namespace App\Http\Controllers;

#use App\Exports\MonthlyReport;
use App\Exports\MonthlyReportExcel;
use App\Models\Car;
use App\Models\Dotation;
use App\Models\Maintenance;
use App\Models\MonthlyReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function monthlyReport()
    {
        $items =  MonthlyReport::whereMonth('date',5)->orderBy('date')->get()->groupBy('car_id');
        $date = Carbon::now();
        return Excel::download(new MonthlyReportExcel($items,$date),'invoice.xlsx');
       // return view('pdf.report.monthlyReport',compact('items','date'));
    }
}
