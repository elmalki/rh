<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMonthlyReportRequest;
use App\Http\Requests\UpdateMonthlyReportRequest;
use App\Models\MonthlyReport;

class MonthlyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return MonthlyReport::whereMonth('date',5)->get()->groupBy('car_id');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMonthlyReportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MonthlyReport $monthlyReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MonthlyReport $monthlyReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMonthlyReportRequest $request, MonthlyReport $monthlyReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MonthlyReport $monthlyReport)
    {
        //
    }
}
