<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaperRequest;
use App\Http\Requests\UpdatePaperRequest;
use App\Models\Paper;
use Inertia\Inertia;

class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Papers/Index', ['items' => Paper::all()]);
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
    public function store(StorePaperRequest $request)
    {
       return  Paper::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Paper $parttype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paper $parttype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaperRequest $request, Paper $parttype)
    {
        $parttype->update($request->all());
        return $parttype->refresh();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paper $parttype)
    {
        //
    }
}
