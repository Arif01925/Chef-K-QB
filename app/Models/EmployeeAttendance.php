<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeAttendance extends Model
{
    use HasFactory;

    protected $table = 'employee_attendance';

    protected $fillable = [
        'employee_id',
        'work_date',
        'in_time',
        'out_time',
        'total_hours',
        'hourly_rate',
        'status'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
