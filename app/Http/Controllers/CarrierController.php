<?php
namespace App\Http\Controllers;

use App\Models\Carrier;
use Illuminate\Http\Request;

class CarrierController extends Controller
{
    public function index()
    {
        $carriers = Carrier::paginate(10);
        return view('admin.carriers.index', compact('carriers'));
    }

    public function show(Carrier $carrier)
    {
        return view('admin.carriers.show', compact('carrier'));
    }

    public function create()
    {
        return view('admin.carriers.create');
    }

    public function edit(Carrier $carrier)
    {
        return view('admin.carriers.edit', compact('carrier'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_info' => 'required|string|max:255',
            'code' => 'required|string|max:255',
        ]);

        Carrier::create($request->only('name', 'contact_info', 'code'));

        return redirect()->route('carriers.index')->with('success', 'Carrier added successfully.');
    }

    public function update(Request $request, Carrier $carrier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_info' => 'required|string|max:255',
        ]);

        $carrier->update($request->only('name', 'contact_info'));

        return redirect()->route('carriers.index')->with('success', 'Carrier updated successfully.');
    }

    public function destroy(Carrier $carrier)
    {
        $carrier->delete();

        return redirect()->route('carriers.index')->with('success', 'Carrier deleted successfully.');
    }
}