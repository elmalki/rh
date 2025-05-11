<?php

namespace App\Http\Controllers;

use App\Exports\MonthlyReportExcel;
use App\Models\Car;
use App\Models\Dotation;
use App\Models\Maintenance;
use App\Models\MonthlyReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function chooseMonth()
    {
        return Inertia::render('Reports/ChooseMonth');
    }

    public function monthlyReport()
    {
        return Excel::download(new MonthlyReportExcel(request()->json()->all()),'invoice.xlsx');
       // return view('pdf.report.monthlyReport',compact('items','date'));
    }
}
