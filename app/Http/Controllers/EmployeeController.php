<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index() {
        try {
            $employees = Employee::orderBy('id', 'desc')->paginate(10);
            return view('employee.index', ['employees'=>$employees]);
        } catch (\Throwable $th) {
            return redirect()->back()
            ->withErrors("Error occured try again");
        }
    }

    public function create() {
        try {
            $companies = Company::select('id', 'name')->get();
            return view('employee.create', ['companies'=>$companies]);
        } catch (\Throwable $th) {
            return redirect()->back()
            ->withErrors("Error occured try again");
        }
    }

    public function store(Request $request) {
        $rules = [
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'company_id'      => 'required|exists:companies,id',
            'email'           => 'required|string|email|max:255|unique:employees',
            'phone'           => 'required|regex:/^(01)[0-9]{9}$/|unique:employees',
        ];

        $this->validate(request(), $rules, [], []);

        Employee::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'company_id' => $request->input('company_id'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);

        return redirect()->route('employee.index', app()->getLocale());
    }

    public function edit($locale, Employee $employee) {
        try {
            $companies = Company::select('id', 'name')->get();
            return view('employee.edit', ['employee'=>$employee, 'companies'=>$companies]);
        } catch (\Throwable $th) {
            return redirect()->back()
            ->withErrors("Error occured try again");
        }
    }

    public function update(Request $request, $locale, Employee $employee) {
        $rules = [
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'company_id'      => 'required|exists:companies,id',
            'email'           => 'required|string|email|max:255|unique:employees,email,'.$employee->id.',id',
            'phone'           => 'required|regex:/^(01)[0-9]{9}$/|unique:employees,phone,'.$employee->id.',id',
        ];

        $this->validate(request(), $rules, [], []);

        $employee->first_name = $request->input('first_name');
        $employee->last_name = $request->input('last_name');
        $employee->company_id = $request->input('company_id');
        $employee->email = $request->input('email');
        $employee->phone = $request->input('phone');
        $employee->save();

        return redirect()->route('employee.index', app()->getLocale());
    }

    public function destroy($locale, Employee $employee) {
        try {
            $employee->delete();
            return back();
        } catch (\Throwable $th) {
            return redirect()->back()
            ->withErrors("Error occured try again");
        }
    }

    public function trashed() {
        try {
            $employees = Employee::onlyTrashed()->orderBy('id', 'desc')->paginate(10);
            return view('employee.trashed', ['employees'=>$employees]);
        } catch (\Throwable $th) {
            return redirect()->back()
            ->withErrors("Error occured try again");
        }
    }

    public function restore($locale, $id) {
        try {
            Employee::onlyTrashed()->where('id', $id)->restore();
            return back();
        } catch (\Throwable $th) {
            return redirect()->back()
            ->withErrors("Error occured try again");
        }
    }

    public function forceDelete($locale, $id) {
        try {
            Employee::onlyTrashed()->where('id', $id)->forceDelete();
            return back();
        } catch (\Throwable $th) {
            return redirect()->back()
            ->withErrors("Error occured try again");
        }
    }
}
