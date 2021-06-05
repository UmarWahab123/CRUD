<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeachrController extends Controller
{
    public function index()
    {
        $teachers = Teacher::orderBy('id', 'DESC')->get();
        return view('teacher', compact('teachers'));
    }
    public function addTeacher(Request $request)
    {

        $teacher = new Teacher();
        $teacher->firstname = $request->firstname;
        $teacher->lastname = $request->lastname;
        $teacher->email = $request->email;
        $teacher->phone = $request->phone;
        $teacher->save();
        return response()->json($teacher);

    }
}
