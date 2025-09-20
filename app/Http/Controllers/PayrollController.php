<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PayrollController extends Controller
{
    public function index()
    {
        // Select only the columns needed for the employee dropdown to
        // avoid loading large objects (photos, timestamps) into memory.
        $employees = Employee::select('id', 'name', 'role', 'department', 'hourly_rate')->get();
        $attendances = EmployeeAttendance::with('employee')->latest()->paginate(6);


        return view('payroll.index', compact('employees', 'attendances'));
    }

    public function store(Request $request)
    {
        Log::debug('payroll.store:start', ['time' => microtime(true)]);

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'work_date' => 'required|date',
            'in_time' => 'nullable|date_format:H:i',
            'out_time' => 'nullable|date_format:H:i',
        ]);

        Log::debug('payroll.store:after_validation', ['time' => microtime(true)]);

        $employee = Employee::findOrFail($request->employee_id);

    Log::debug('payroll.store:after_employee_lookup', ['employee_id' => $request->employee_id, 'time' => microtime(true)]);

        $totalHours = 0;
        if ($request->in_time && $request->out_time) {
            $in = Carbon::createFromFormat('H:i', $request->in_time);
            $out = Carbon::createFromFormat('H:i', $request->out_time);

            if ($in->greaterThanOrEqualTo($out)) {
                return redirect()->back()->withErrors(['out_time' => 'Out time must be after in time.']);
            }

            $totalHours = $in->floatDiffInHours($out);
        }

        EmployeeAttendance::create([
            'employee_id' => $employee->id,
            'work_date' => $request->work_date,
            'in_time' => $request->in_time,
            'out_time' => $request->out_time,
            'total_hours' => $totalHours,
            'hourly_rate' => $employee->hourly_rate,
            'status' => 'Unpaid',
        ]);

    Log::debug('payroll.store:after_create', ['time' => microtime(true)]);

    // mark just before returning so we can detect whether session/middleware
    // is delaying the response after DB create
    Log::debug('payroll.store:before_redirect', ['time' => microtime(true)]);

    return redirect()->back()->with('success', 'Attendance saved successfully.');
    }

    public function edit($id)
    {
        $entry = EmployeeAttendance::findOrFail($id);
        $employees = Employee::all();
        return view('payroll.edit', compact('entry', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'work_date' => 'required|date',
            'in_time' => 'nullable|date_format:H:i',
            'out_time' => 'nullable|date_format:H:i',
        ]);

        $attendance = EmployeeAttendance::findOrFail($id);
        $employee = Employee::findOrFail($request->employee_id);

        $totalHours = 0;
        if ($request->in_time && $request->out_time) {
            $in = Carbon::createFromFormat('H:i', $request->in_time);
            $out = Carbon::createFromFormat('H:i', $request->out_time);

            if ($in->greaterThanOrEqualTo($out)) {
                return redirect()->back()->withErrors(['out_time' => 'Out time must be after in time.']);
            }

            $totalHours = $in->floatDiffInHours($out);
        }

        $attendance->update([
            'employee_id' => $employee->id,
            'work_date' => $request->work_date,
            'in_time' => $request->in_time,
            'out_time' => $request->out_time,
            'total_hours' => $totalHours,
            'hourly_rate' => $employee->hourly_rate,
        ]);

        return redirect()->route('payroll.index')->with('success', 'Attendance updated successfully.');
    }

    public function destroy($id)
    {
        $entry = EmployeeAttendance::findOrFail($id);
        $entry->delete();

        return redirect()->back()->with('success', 'Attendance deleted successfully.');
    }

    public function summary(Request $request)
    {
        $weekStart = $request->input('week_start') ? Carbon::parse($request->week_start) : now()->startOfWeek();
        $weekEnd = $request->input('week_end') ? Carbon::parse($request->week_end) : now()->endOfWeek();
        $employeeId = $request->input('employee_id');

        $query = EmployeeAttendance::with('employee')
            ->whereBetween('work_date', [$weekStart->toDateString(), $weekEnd->toDateString()]);

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        $records = $query->get();


        $employees = Employee::all();

        return view('payroll.summary', compact('records', 'weekStart', 'weekEnd', 'employees', 'employeeId'));
    }
    public function print(Request $request)
    {
    $employeeId = $request->employee_id;
    $startDate = $request->start_date;
    $endDate = $request->end_date;

    $employee = \App\Models\Employee::find($employeeId);

    if (!$employee) {
        abort(404, 'Employee not found');
    }

    $records = \App\Models\EmployeeAttendance::where('employee_id', $employeeId)
        ->whereBetween('work_date', [$startDate, $endDate])
        ->get();

    $totalPay = $records->sum('daily_pay');

    return view('payroll.print', compact('employee', 'records', 'startDate', 'endDate', 'totalPay'));
    }

}
