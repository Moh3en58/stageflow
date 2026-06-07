<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use Illuminate\Http\Request;
use App\Models\Company;
class InternshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
{
    $internships = Internship::all();

    return view('internships.index', compact('internships'));
}    /**
     * Show the form for creating a new resource.
     */
  public function create()
{
    $companies = Company::all();

    return view('internships.create', compact('companies'));
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    Internship::create([
        'user_id' => auth()->id(),
    'company_id' => $request->company_id,
        'title' => $request->title,
        'description' => $request->description,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'status' => 'pending',
    ]);

    return redirect()->route('internships.index');
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
    public function edit(Internship $internship)
{
    return view('internships.edit', compact('internship'));
}

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Internship $internship)
{
    $internship->update([
        'title' => $request->title,
        'description' => $request->description,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
    ]);

    return redirect()->route('internships.index');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Internship $internship)
{
    $internship->delete();

    return redirect()->route('internships.index');
}
}
