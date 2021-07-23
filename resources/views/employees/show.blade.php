@include('admin.header');
@extends('employees.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <a class="btn btn-primary" href="{{ route('employees.index') }}"> Back</a>
            </div>
{{--            <div class="pull-left">--}}
{{--                <h2> View Employee</h2>--}}
{{--            </div>--}}

            <div class="pull-right">
                <form action="{{ route('employees.destroy',$employee->id) }}" method="POST">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>

            </div>

        </div>
    </div>
<hr>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $employee->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                {{ $employee->email }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Address:</strong>
                {{ $employee->address }}
            </div>
        </div>
        <?php
        $dept_show=$departments->find($employee->dept_id);
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Department:</strong>
                {{ $dept_show->department }}
            </div>
        </div>
        <?php
        $design_show=$designations->find($employee->dept_id);
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Designation:</strong>
                {{ $design_show->designation }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Photo:</strong>
{{--                <img src="{{ asset($employee->photo) }}" width="50" height="50">--}}
                <img src="{{url('/photo/')}}/{{$employee->photo}}" width="50" height="50">
            </div>
        </div>
    </div>
@endsection
<script src='{{ asset("plugins/jquery/jquery.min.js") }}'></script>
@include('admin.footer');
