<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/',[CourseController::class,'create'])->name('course.create');
Route::post('/course/store',[CourseController::class,'store'])->name('course.store');

