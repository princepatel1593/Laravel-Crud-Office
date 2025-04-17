<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\OfficeController;


Route::get('/', function () {
    return view('welcome');
});

//Main Page Route
Route::get('/main',[MainController::class,'index'])->name('main.index');
Route::get('/office-data', [MainController::class, 'getOfficeData'])->name('office.data');



//Site Page Route
Route::get('/sites/viewsite',[SiteController::class,'site'])->name('site.view');
Route::get('/sites/create_site',[SiteController::class,'create'])->name('site.create');
Route::post('/sites/store',[SiteController::class,'store'])->name('site.store');
Route::get('/sites/data', [SiteController::class, 'getSites'])->name('site.data');
Route::get('/sites/{id}/edit', [SiteController::class, 'edit'])->name('site.edit');
Route::put('/sites/{id}', [SiteController::class, 'update'])->name('site.update');
Route::delete('/sites/{id}', [SiteController::class, 'destroy'])->name('site.destroy');


//Block Page Route
Route::get('/blocks/viewblock',[BlockController::class,'block'])->name('block.view');
Route::get('/blocks/create_block',[BlockController::class,'create'])->name('block.create');
Route::post('/blocks/store',[BlockController::class,'store'])->name('block.store');
Route::put('/blocks/{id}', [BlockController::class, 'update'])->name('block.update');
Route::get('/blocks/{id}/edit', [BlockController::class, 'edit'])->name('block.edit');
Route::get('/blocks/data', [BlockController::class, 'getData'])->name('block.data');
Route::delete('/blocks/{id}', [BlockController::class, 'destroy'])->name('block.destroy');




//Floor Page Route
Route::get('/floors/viewfloor',[FloorController::class,'floor'])->name('floor.view');
Route::get('/floors/create_floor',[FloorController::class,'create'])->name('floor.create');
Route::post('/floors/store',[FloorController::class,'store'])->name('floor.store');
Route::put('/floors/{id}', [FloorController::class, 'update'])->name('floor.update');
Route::get('/floors/{id}/edit', [FloorController::class, 'edit'])->name('floor.edit');
Route::get('/floors/data', [FloorController::class, 'getData'])->name('floor.data');
Route::delete('/floors/{id}', [FloorController::class, 'destroy'])->name('floor.destroy');
Route::get('/get-blocks/{site_id}', [FloorController::class, 'getBlocksBySite']);


//office page route 
Route::get('/offices/viewoffice', [OfficeController::class, 'office'])->name('office.view');
Route::get('/offices/create_office', [OfficeController::class, 'create'])->name('office.create');
Route::post('/offices/store', [OfficeController::class, 'store'])->name('office.store');
Route::get('/offices/data', [OfficeController::class, 'getOfficeData'])->name('office.data');
Route::get('/get-floors/{block_id}', [OfficeController::class, 'getFloorsByBlock']);
Route::get('/offices/edit/{office}', [OfficeController::class, 'edit'])->name('office.edit');
Route::put('/offices/update/{office}', [OfficeController::class, 'update'])->name('office.update');
Route::delete('/offices/{id}', [OfficeController::class, 'destroy'])->name('office.destroy');


