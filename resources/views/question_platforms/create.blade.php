@extends('layouts.app')

@section('content')
    <div class="content">

        @include('adminlte-templates::common.errors')

        <div class="card">
            <div class="card-header card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><b>Create Question Platform</b></h4>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('questionPlatforms.index') }}" class="btn btn-primary"> <i
                                class="fas fa-list pr-2"></i>
                            List Question Platform</a>
                    </div>
                </div>
            </div>
            {!! Form::open(['route' => 'questionPlatforms.store']) !!}

            <div class="card-body">
                <div class="row">
                    @include('question_platforms.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('questionPlatforms.index') }}" class="btn btn-default">
                    @lang('crud.cancel')
                </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
