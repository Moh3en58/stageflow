<?php

namespace App\Http\Controllers;
use App\Models\Logbook;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    return view('logbooks.index');
}

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    return view('logbooks.create');
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    return redirect()->route('logbooks.index');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
