<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeeExport implements FromCollection
{
//create function for export
    public function heading(): array
    {
        return [
            'Id',
            'Name',
            'Email',
            'Phone',
            'Salary',
            'Department',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Employee::all();
        //return collect(Employee::getEmployee());
    }
}
