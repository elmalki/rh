<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeaveRequest;
use App\Http\Requests\UpdateLeaveRequest;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Personnel;
use Inertia\Inertia;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Leaves/Index', ['items' => Leave::paginate(10),'sort_fields'=>request()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Leaves/Create',['leaveTypes'=>LeaveType::all(),'personnels'=>Personnel::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeaveRequest $request)
    {
         Leave::create($request->all());
         return redirect()->route('leave.index')->banner( 'Congé est créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        return Inertia::render('Leaves/Edit',['leave'=>$leave,'leaveTypes'=>LeaveType::all(),'personnels'=>Personnel::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeaveRequest $request, Leave $leave)
    {
        $leave->update($request->all());
        return redirect()->route('leaves.index')->banner( 'Congé est modifé avec succès.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        //
    }
}
