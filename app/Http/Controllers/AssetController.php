<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::all();
        return view('assets.index', compact('assets'));
    }

    public function create()
    {
        return view('assets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'value' => 'required|numeric',
            'purchase_date' => 'required|date',
            'location' => 'nullable|string',
        ]);

        Asset::create($request->all());

        return redirect()->route('asset-management.index')->with('success', 'Asset created successfully.');
    }


    public function edit($asset)
    {
        $asset = Asset::find($asset);
        return view('assets.edit', compact('asset'));
    }

    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'value' => 'required|numeric',
            'purchase_date' => 'required|date',
            'location' => 'nullable|string',
        ]);

        $asset->update($request->all());

        return redirect()->route('asset-management.index')->with('success', 'Asset updated successfully.');
    }

    public function destroy($asset)
    {
        try {
            Asset::find($asset)->delete();
            return  back()->with('success', 'Asset deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('success', 'Asset deleted Failed.');
        }
    }
}
