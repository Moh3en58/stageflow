<?php

namespace App\Http\Controllers;

use App\Models\Competency;
use Illuminate\Http\Request;

class CompetencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $competencies = Competency::all();

    return view('competencies.index', compact('competencies'));
}

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    return view('competencies.create');
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    Competency::create([
        'title' => $request->title,
        'description' => $request->description,
        'weight' => 1,
        'active' => true,
    ]);

    return redirect()->route('competencies.index');
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
