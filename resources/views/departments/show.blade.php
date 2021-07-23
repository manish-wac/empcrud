@include('admin.header');
@extends('departments.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">

            <div class="pull-left">
                <a class="btn btn-primary" href="{{ route('departments.index') }}"> Back</a>
            </div>
            <div class="pull-right">
                <form action="{{ route('departments.destroy',$department->id) }}" method="POST">

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
                <strong>Department:</strong>
                {{ $department->department }}
            </div>
        </div>
    </div>
@endsection
<script src='{{ asset("plugins/jquery/jquery.min.js") }}'></script>
@include('admin.footer');
