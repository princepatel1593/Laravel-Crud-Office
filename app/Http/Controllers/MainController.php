<?php

namespace App\Http\Controllers;
use App\Models\Office;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class MainController extends Controller
{
    //

    public function index(){
        return view('main');
    }
    
}
