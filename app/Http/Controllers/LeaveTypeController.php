<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeaveTypeRequest;
use App\Http\Requests\UpdateLeaveTypeRequest;
use App\Models\LeaveType;
use Inertia\Inertia;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('LeaveTypes/Index', ['items'=>LeaveType::all()]);
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
    public function store(StoreLeaveTypeRequest $request)
    {
        return LeaveType::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaveType $leavetype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaveType $leavetype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeaveTypeRequest $request, LeaveType $leavetype)
    {
        $leavetype->update($request->all());
        return $leavetype->refresh();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaveType $leavetype)
    {
        $leavetype->delete();
        return redirect()->route('leavetypes.index')->dangerBanner('Type congé supprimé avec succès.');
    }
}
