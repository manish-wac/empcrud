<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class DepartmentController extends Controller
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

            $data = Department::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $show_url=route('departments.show', $row->id);
                    $edit_url=route('departments.edit', $row->id);
                    $delete_url=route('departments.destroy', $row->id);

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
        return view('departments.index', compact('departments', 'designations'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('departments.create');

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
            'department' => 'required|unique',
        ]);

        Department::create($request->all());

        return redirect()->route('departments.index')
            ->with('success','Department created successfully.');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {

        return view('departments.show',compact('department'));


        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {

        return view('departments.edit',compact('department'));


        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {

        $request->validate([
            'department' => 'required|unique',
        ]);

        $department->update($request->all());

        return redirect()->route('departments.index')
            ->with('success','Department updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {

        $department->delete();

        return redirect()->route('departments.index')
            ->with('success','Department deleted successfully');


        return redirect("login")->withSuccess('Opps! You do not have access');
    }
}
