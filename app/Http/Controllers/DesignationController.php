<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class DesignationController extends Controller
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

            $data = Designation::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $show_url=route('designations.show', $row->id);
                    $edit_url=route('designations.edit', $row->id);
                    $delete_url=route('designations.destroy', $row->id);

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
        return view('designations.index', compact('departments', 'designations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('designations.create');

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
            'designation' => 'required',
            'designation' => 'required|unique',
        ]);

        Designation::create($request->all());

        return redirect()->route('designations.index')
            ->with('success','Designation created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function show(Designation $designation)
    {

        return view('designations.show',compact('designation'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function edit(Designation $designation)
    {

        return view('designations.edit',compact('designation'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Designation $designation)
    {

        $request->validate([
            'designation' => 'required',
            'designation' => 'required|unique',
        ]);

        $designation->update($request->all());

        return redirect()->route('designations.index')
            ->with('success','Designation updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Designation $designation)
    {
        $designation->delete();
        return redirect()->route('designations.index')
            ->with('success','Designation deleted successfully');
    }
}
