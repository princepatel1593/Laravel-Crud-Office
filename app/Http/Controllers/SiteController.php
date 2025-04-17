<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use Yajra\DataTables\Facades\DataTables;


class SiteController extends Controller
{
    //
    public function site(){
        $sites = Site::all();
        return view('sites.view_site', compact('sites'));
    }

    public function create(){
        return view('sites.create_site');
    }

    public function store(Request $request){

        $request->validate([
            'site_name'=>'required|string|max:255',
        ]);

        Site::create([
            'site_name'=>$request->site_name,
        ]);
        return redirect()->route('site.view')->with('success','Site Added Succesfully!');
    }

    public function getSites(Request $request)
    {
        if ($request->ajax()) {
            $data = Site::select('id', 'site_name');
            return Datatables::of($data)
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('site.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="' . $row->id . '">Delete</button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function edit($id) {
        $site = Site::findOrFail($id);
        return view('sites.create_site', compact('site'));
    }
    
    public function update(Request $request, $id) {
        $request->validate([
            'site_name' => 'required|string|max:255',
        ]);
    
        $site = Site::findOrFail($id);
        $site->update([
            'site_name' => $request->site_name,
        ]);
    
        return redirect()->route('site.view')->with('success', 'Site updated successfully!');
    }
    
    public function destroy($id)
    {
        $site = Site::findOrFail($id);
        $site->delete();

        // Return a JSON response with success message
        return response()->json(['success' => true, 'message' => 'Site deleted successfully!']);
    }
    
}
