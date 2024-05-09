@extends('layouts.app')
@section('title')
    Create School
@endsection
@section('css')
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1">
                        SCHOOL
                    </h4>
                </div>
                {!! Form::open(['route' => 'schools.store']) !!}
                <div class="card-body">
                    <div class="row">
                        @include('province::pages.schools.fields')
                    </div>
                </div>
                <div class="card-footer">
                    {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
