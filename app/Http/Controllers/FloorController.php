<?php
namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Block;
use App\Models\Site;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FloorController extends Controller
{
    // Display floors view
    public function floor()
    {
        $sites = Site::all(); // Assuming you have sites
        $blocks = Block::all(); // Fetch all blocks, but this can be filtered by site
        return view('floors.view_floor', compact('sites', 'blocks'));
    }

    // Show create floor form
    public function create()
    {
        $sites = Site::all();
        $blocks = Block::all();
        return view('floors.create_floor', compact('sites', 'blocks'));
    }

    // Store a new floor
    public function store(Request $request)
    {
        $validated = $request->validate([
            'block_id' => 'required|exists:blocks,id',
            'floor_name' => 'required|string|min:2',
        ]);
    
        Floor::create($validated);
    
        return response()->json(['message' => 'Floor created successfully!']);
    }

    // Show edit form for a floor
    public function edit($id)
    {
        $floor = Floor::findOrFail($id);
        $sites = Site::all();

        // Get the site ID through the block relationship
        $siteId = $floor->block->site_id ?? null;
        $blocks = Block::where('site_id', $siteId)->get();

        return view('floors.create_floor', compact('floor', 'sites', 'blocks', 'siteId'));
    }

    

    // Update floor data
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'block_id' => 'required|exists:blocks,id',
            'floor_name' => 'required|string|min:2',
        ]);

        $floor = Floor::findOrFail($id);
        $floor->update($validated);

        return response()->json(['message' => 'Floor updated successfully!']);
    }   

    // Get floors by block (AJAX request)
    public function getBlocksBySite($site_id)
    {
        $blocks = Block::where('site_id', $site_id)->get();

        return response()->json(['blocks' => $blocks]);
    }

    // Handle floor deletion
    public function destroy($id)
    {
        $floor = Floor::findOrFail($id);
        $floor->delete();

        return response()->json(['message' => 'Floor deleted successfully']);
    }

   
 
    
    public function getData()
    {
        // Eager load block and the block's site
        $floors = Floor::with(['block.site'])->get();
    
        return DataTables::of($floors)
            ->addColumn('site_name', function ($floor) {
                return $floor->block->site->site_name ?? 'N/A';
            })
            ->addColumn('block_name', function ($floor) {
                return $floor->block->block_name ?? 'N/A';
            })
            ->addColumn('floor_name', function ($floor) {
                return $floor->floor_name;
            })
            ->addColumn('action', function ($floor) {
                return '
                    <a href="' . route('floor.edit', $floor->id) . '" class="btn btn-sm btn-primary me-1">Edit</a>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="' . $floor->id . '">Delete</button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    

}
