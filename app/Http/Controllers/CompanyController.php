<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $this->authorizeManagement();

        $companies = Company::orderBy('name')->get();

        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        $this->authorizeManagement();

        return view('companies.create');
    }

    public function store(Request $request)
    {
        $this->authorizeManagement();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'contact_person' => ['nullable', 'string', 'max:255'],
        ]);

        Company::create($validated);

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company created successfully.');
    }

    public function show(Company $company)
    {
        $this->authorizeManagement();

        return view('companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        $this->authorizeManagement();

        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $this->authorizeManagement();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'contact_person' => ['nullable', 'string', 'max:255'],
        ]);

        $company->update($validated);

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $this->authorizeManagement();

        if ($company->internships()->exists()) {
            return redirect()
                ->route('companies.index')
                ->with(
                    'error',
                    'This company cannot be deleted because it is linked to one or more internships.'
                );
        }

        $company->delete();

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company deleted successfully.');
    }

    private function authorizeManagement(): void
    {
        if (!in_array(auth()->user()->role, ['admin', 'teacher', 'committee'], true)) {
            abort(403, 'You are not allowed to manage companies.');
        }
    }
}