<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use App\Models\Employee;
use Excel;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //create a function adding the employEE
    public function addEmployee()
    {
        $employees = [
            ['name' => 'khan', 'email' => 'khan@gmai.com', 'phone' => '123456789', 'salary' => '400000', 'department' => 'Accounting'],

            ['name' => 'inam', 'email' => 'inam@gmai.com', 'phone' => '1234556789', 'salary' => '500000', 'department' => 'marketing'],

            ['name' => 'umar', 'email' => 'umar@gmai.com', 'phone' => '12345678916', 'salary' => '600000', 'department' => 'programming'],

            ['name' => 'waqas', 'email' => 'waqas@gmai.com', 'phone' => '12347756789', 'salary' => '700000', 'department' => 'Mobile apps'],

            ['name' => 'latif', 'email' => 'latif@gmai.com', 'phone' => '1234567654689', 'salary' => '800000', 'department' => 'developer'],
        ];
        Employee::insert($employees);
        return 'record has been inserted successfully!';
    }
    //create a function to export data into exel
    public function exportIntoExcel()
    {
        return Excel::download(new EmployeeExport, 'employeelist.xlsx');
    }
    //create a function to export data into CSV
    public function exportIntoCSV()
    {
        return Excel::download(new EmployeeExport, 'employeelist.csv');

    }
    //the  below one are the functions for import data into the database
    public function importForm()
    {
        return view('import-form');
    }
    //finally write a function for import
    public function import(Request $request)
    {
        Excel::import(new EmployeeImport, $request->file);
        return "Record imported suceessfully";
    }

}
