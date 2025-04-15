<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrier; // Adjust if your model name is different

class AdminCarrierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carriers = Carrier::latest()->paginate(10);
        return view('admin.carriers.index', compact('carriers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.carriers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:carriers',
            // Add other validation rules
        ]);

        Carrier::create($request->all());

        return redirect()->route('carriers.index')
            ->with('success', 'Carrier created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Carrier $carrier)
    {
        return view('admin.carriers.show', compact('carrier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carrier $carrier)
    {
        return view('admin.carriers.edit', compact('carrier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carrier $carrier)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:carriers,code,'.$carrier->id,
            // Add other validation rules
        ]);

        $carrier->update($request->all());

        return redirect()->route('carriers.index')
            ->with('success', 'Carrier updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carrier $carrier)
    {
        $carrier->delete();

        return redirect()->route('carriers.index')
            ->with('success', 'Carrier deleted successfully');
    }
} 