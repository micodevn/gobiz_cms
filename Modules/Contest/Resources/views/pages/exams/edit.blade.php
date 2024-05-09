@extends('layouts.app')
@section('content')
    <div class="content px-3">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="card">
                    {!! Form::model($exam, ['route' => ['exams.update', $exam->id], 'method' => 'patch']) !!}

                    <div class="card-body">
                        <div class="row">
                            @include('contest::pages.exams.fields')
                        </div>
                    </div>

                    <div class="card-footer">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                        <a href="{{ route('exams.index') }}" class="btn btn-default">
                            @lang('crud.cancel')
                        </a>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('page_scripts')
    <script src="/storage/js/init-selected-api.js?v={{config('cdn.version_script')}}" defer></script>
@endpush
