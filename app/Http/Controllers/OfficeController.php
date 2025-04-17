<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Block;
use App\Models\Site;
use App\Models\Floor;
use App\Models\Office;
use Yajra\DataTables\Facades\DataTables;

class OfficeController extends Controller
{
    // Show Office Management Page
    public function office(){
        return view('offices.view_office');
    }

    // Show Create Office Page
    public function create(){
        $sites = Site::all();
        $blocks = Block::all();
        $floors = Floor::all();
        return view('offices.create_office', compact('sites', 'blocks', 'floors'));
    }

    // Store Office Data
    public function store(Request $request)
    {
        $request->validate([
            'floor_id' => 'required|exists:floors,id',
            'office_name' => 'required|string|max:255',
        ]);

        // Create the office
        Office::create([
            'floor_id' => $request->floor_id,
            'office_name' => $request->office_name,
        ]);

        // Redirect with success message
        return redirect()->route('office.view')->with('success', 'Office added successfully!');
    }

    public function getFloorsByBlock($blockId)
    {
        // Fetch the floors that belong to the selected block
        $floors = Floor::where('block_id', $blockId)->get();
        return response()->json(['floors' => $floors]);
    }

    // Fetch office data for DataTable
    public function getOfficeData(Request $request)
    {
        $offices = Office::with(['floor.block.site'])->select('offices.*');
    
        return DataTables::of($offices)
            ->addColumn('site_name', function ($office) {
                return $office->floor->block->site->site_name ?? '-';
            })
            ->addColumn('block_name', function ($office) {
                return $office->floor->block->block_name ?? '-';
            })
            ->addColumn('floor_name', function ($office) {
                return $office->floor->floor_name ?? '-';
            })
            ->addColumn('action', function ($office) {
                return '
                    <a href="' . route('office.edit', $office->id) . '" class="btn btn-sm btn-primary">Edit</a>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="' . $office->id . '">Delete</button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    // Show Edit Office Page
    public function edit($id)
    {
        $office = Office::findOrFail($id);
        $sites = Site::all();
        $blocks = Block::where('site_id', $office->floor->block->site_id)->get(); // Only blocks for the current site's site_id
        $floors = Floor::where('block_id', $office->floor->block_id)->get(); // Only floors for the selected block

        return view('offices.create_office', compact('office', 'sites', 'blocks', 'floors'));
    }

    // Update Office Data
    public function update(Request $request, Office $office)
    {
        $request->validate([
            'floor_id' => 'required|exists:floors,id',
            'office_name' => 'required|string|max:255',
        ]);

        // Update the office
        $office->update([
            'floor_id' => $request->floor_id,
            'office_name' => $request->office_name,
        ]);

        // Redirect with success message
        return redirect()->route('office.view')->with('success', 'Office updated successfully!');
    }

    public function destroy($id)
    {
        $office = Office::findOrFail($id);
        $office->delete();

        return response()->json(['success' => 'Office deleted successfully!']);
    }
}
