<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Block;
use App\Models\Site;
use Yajra\DataTables\Facades\DataTables;

class BlockController extends Controller
{
    //
    public function block(){
        return view('blocks.view_block');
    }

    public function create(){
        $sites = Site::all();
        return view('blocks.create_block', compact('sites'));
    }

    public function store(Request $request)
    {
        
            $request->validate([
                'site_id'=>'required',
                'block_name'=>'required|max:255',
            ]);

            Block::create($request->only('site_id', 'block_name'));

        return redirect()->route('block.view')->with('success', 'Block added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'site_id' => 'required',
            'block_name' => 'required|string|max:255',
        ]);

        $block = Block::findOrFail($id);
        $block->update([
            'site_id' => $request->site_id,
            'block_name' => $request->block_name,
        ]);

        return response()->json(['success' => true]);
    }
    public function getData()
    {
        $blocks = Block::with('site')->select('id', 'site_id', 'block_name');

        return DataTables::of($blocks)
            ->addColumn('site.site_name', function($block) {
                return $block->site->site_name ?? '';
            })
            ->addColumn('action', function($block) {
                return '
                    <a href="' . route('block.edit', $block->id) . '" class="btn btn-sm btn-primary me-1">Edit</a>
                    <button class="btn btn-sm btn-danger delete-block" data-id="' . $block->id . '">Delete</button>
                ';
            })
            ->rawColumns(['action']) // allow HTML in action column
            ->make(true);
    }
    public function edit($id)
    {
        $block = Block::findOrFail($id);
        $sites = Site::all();
        return view('blocks.create_block', compact('block', 'sites'));
    }
    public function destroy($id)
    {
        $block = Block::findOrFail($id);
        $block->delete();
    
        return response()->json(['success' => true, 'message' => 'Block deleted successfully!']);
    }
}
