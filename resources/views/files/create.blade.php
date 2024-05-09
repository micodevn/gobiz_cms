@extends('layouts.app')

@section('content')
    <div class="content">

        @include('adminlte-templates::common.errors')

        <div class="card">
            <div class="card-header card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><b>Create File</b></h4>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('files.index') }}" class="btn btn-primary"> <i
                                class="fas fa-list pr-2"></i>
                            List File</a>
                    </div>
                </div>
            </div>
            {!! Form::open(['route' => 'files.store', 'files' => true]) !!}

            <div class="card-body">
                <div class="row">
                    @include('files.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary', 'id' => 'file-create-form']) !!}
                <a href="{{ route('files.index') }}" class="btn btn-default">
                    @lang('crud.cancel')
                </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
@push('page_scripts')
    <script src="/storage/js/init-selected-api.js?v={{config('cdn.version_script')}}" defer></script>
@endpush
