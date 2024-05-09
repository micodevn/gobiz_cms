@extends('layouts.app')
@php
    $package = $package ?? new \Modules\Province\Entities\Province(old());
@endphp
@section('content')
    <div class="content">

        <div class="card">
            {!! Form::model($package, ['route' => ['exams.store'], 'method' => 'post']) !!}
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
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
@push('page_scripts')
    <script src="/storage/js/init-selected-api.js?v={{config('cdn.version_script')}}" defer></script>
@endpush
