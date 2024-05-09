@extends('layouts.app')
@section('title')
    Nhóm đề thi
@endsection
@section('content')
    {!! Form::open(['route' => 'contests.store']) !!}
    <div class="row">
        @include('contest::pages.contests.fields')
    </div>
    <div class="row">
        <div class="col-10">
            <div class="card">
                <div class="card-footer" style="text-align: right">
                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    <a href="{{ route('contests.index') }}" class="btn btn-default">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
@push('page_scripts')
    <script src="/storage/js/init-selected-api.js?v={{config('cdn.version_script')}}" defer></script>
@endpush
