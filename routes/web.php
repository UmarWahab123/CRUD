<?php

use App\Http\Controllers\contactFormController;
use App\Http\Controllers\DropzoneController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LazyLoadImageController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeachrController;
use App\Http\Controllers\TinyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Route::get('/add-employee', [EmployeeController::class, 'addEmployee']);
Route::get('/export-excel', [EmployeeController::class, 'exportIntoExcel']);
Route::get('/export-csv', [EmployeeController::class, 'exportIntoCSV']);

Route::get('/import-form', [EmployeeController::class, 'importForm']);
Route::post('/import', [EmployeeController::class, 'import'])->name('employee.import');

Route::get('/dropzone', [DropzoneController::class, 'dropzone']);
Route::post('/dropzone-store', [DropzoneController::class, 'dropzoneStore'])->name('dropzone.store');

Route::get('/lazyloadimage', [LazyLoadImageController::class, 'lazyLoadImage']);

Route::get('/tinymce', [TinyController::class, 'tinyMce']);

//Below are the Route of image CRUD
Route::get('/add-student', [StudentController::class, 'addStudent']);

Route::post('/add-student', [StudentController::class, 'storeStudent'])->name('student.store');

Route::get('/all-student', [StudentController::class, 'student']);

Route::get('/edit-student/{id}', [StudentController::class, 'editStudent']);

Route::post('/update-student', [StudentController::class, 'updateStudent'])->name('student-update');

Route::get('/delete-student/{id}', [StudentController::class, 'deleteStudent']);

//route of contactform
Route::get('/contact-us', [contactFormController::class, 'contact']);

Route::post('/send-message', [contactFormController::class, 'sendEmail'])->name('contact.send');
//Routes for AJAx
Route::get('/teacher', [TeachrController::class, 'index']);
Route::post('/add-teacher', [TeachrController::class, 'addTeacher'])->name('teacher.add');
