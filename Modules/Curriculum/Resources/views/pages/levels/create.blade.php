@extends('layouts.app')

@section('content')
    @include('adminlte-templates::common.errors')
    <div class="card">
        <div class="card-header card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1"><b>Thêm mới khóa học</b></h4>
            <div class="flex-shrink-0">
                <div class="form-check form-switch form-switch-right form-switch-md">
                    <a href="{{ route('levels.index') }}" class="btn btn-primary"> <i
                            class="fas fa-list pr-2"></i>
                        Danh sách</a>
                </div>
            </div>
        </div>
        {!! Form::open(['route' => 'levels.store']) !!}

        <div class="card-body">

            <div class="row">
                @include('curriculum::pages.levels.fields')
            </div>
            <div class="row">
                <div class="form-group col-12">
                    <div class="list-stage my-3">
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            <a href="{{ route('levels.index') }}" class="btn btn-default"> Cancel </a>
        </div>

        {!! Form::close() !!}

    </div>
@endsection
