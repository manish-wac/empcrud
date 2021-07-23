<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Employee::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $show_url=route('employees.show', $row->id);
                    $edit_url=route('employees.edit', $row->id);
                    $delete_url=route('employees.destroy', $row->id);

//                    $btn0 = '<form action='.$delete_url.' method="POST">';
                    $btn = '<a href='.$show_url.' class="edit btn btn-primary btn-sm">View</a>';
                    $btn1 = ' <a href='.$edit_url.' class="edit btn btn-primary btn-sm">Edit</a>';
//                    $btn2 = ' <button type="submit" class="btn btn-danger">Delete</button>';
                    return $btn.$btn1;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $departments = Department::all();
        $designations = Designation::all();
        return view('employees.index', compact('departments', 'designations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $departments = Department::all();
        $designations = Designation::all();
        return view('employees.create')->with('departments', $departments)
            ->with('designations', $designations);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'unique:users,email',
            'password' => 'required',
            'address' => 'required',
            'photo' => 'required',
            'dept_id' => 'required',
            'design_id' => 'required',
        ]);


        $input = $request->all();

//        print_r($input);
//        exit;

        if ($image = $request->file('photo')) {
            $destinationPath = 'photo/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }

        Employee::create($input);

        $this->send_email($input['email']);


        return redirect()->route('employees.index')
            ->with('success','Employee created successfully.');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {

        $departments = Department::all();
            $designations = Designation::all();
        return view('employees.show',compact('employee'))
            ->with('departments', $departments)
            ->with('designations', $designations);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {

        $departments = Department::all();
        $designations = Designation::all();
        return view('employees.edit',compact('employee'))
            ->with('departments', $departments)
            ->with('designations', $designations);


    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'unique:users,email',
            'address' => 'required',
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index')
            ->with('success','Employee updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */


    public function destroy(Employee $employee)
    {

        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success','Employee deleted successfully');
    }


    public function send_email($email)
    {
        $product_email=$email;
        $details = [
            'title' => 'EmpCRUD Registration Successful',
            'body' => 'Login access using   '.$product_email,
        ];

        \Mail::to($product_email)->send(new \App\Mail\MyTestMail($details));

        return redirect()->route('employees.index')
            ->with('success','Employee created and emailed successfully');
    }



}
