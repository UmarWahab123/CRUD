<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
    use HasFactory;
    //here just add the table name
    protected $table = "employees";

    //this is for import the data
    protected $fillable = ['name', 'email', 'Phone', 'salary', 'department'];

    //create funcion for selection of column or getEmployee
    public function getEmployee()
    {
        $records = DB::table('employees(')->select('name', 'mail', 'phone', 'salary', 'department')->get()->toArray();
        return $records;
    }
}
