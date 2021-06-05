<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function addStudent()
    {
        return view('add-student');
    }

    //this is a function to insert(store) the student record in the DB;
    public function storeStudent(Request $request)
    {
        $name = $request->name;
        $image = $request->file('file');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images'), $imageName);

        $student = new Student();
        $student->name = $name;
        $student->profileimage = $imageName;
        $student->save();

        return redirect('/all-student')->with('student_added', 'student record has been inserted successfully!');

    }
    //function to fetch all the record
    public function student()
    {
        // $student = Student::all();
        $student = Student::latest()->paginate(3);
        return view('all-students', compact('student'));
    }
    //function for edit the user
    public function editStudent($id)
    {
        $student = Student::find($id);
        return view('edit-student', compact('student'));
    }
    //function for update the student
    public function updateStudent(Request $request)
    {
        $name = $request->name;
        $image = $request->file('file');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images'), $imageName);

        $student = Student::find($request->id);
        $student->name = $name;
        $student->profileimage = $imageName;
        $student->save();
        return redirect('/all-student')->with('student-updated', 'student updated successfully!');

    }
    //function for delete the student
    public function deleteStudent($id)
    {
        $student = Student::find($id);
        // $public_path = unlink(public_path('images'). $student->profileimages);
        // $imageName = $student->profileimage;

        // $image_path = public_path('\images') . '\'  . $imageName;
        // unlink($image_path);
        $student->delete();

        return redirect('/all-student')->with('student_deleted', 'student has been deleted successfully!');

    }

}
