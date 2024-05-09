@extends('layouts.app')
@section('contest-title')
    Edit Contest
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="content px-3">
                {!! Form::model($contest, ['route' => ['contests.update', $contest->id], 'method' => 'patch']) !!}
                @include('contest::pages.contests.fields')
                <div class="card">
                    <div class="card-footer" style="text-align: right">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                        <a href="{{ route('contests.index') }}" class="btn btn-default">
                            @lang('crud.cancel')
                        </a>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@push('page_scripts')
    <script src="/storage/js/init-selected-api.js?v={{config('cdn.version_script')}}" defer></script>
@endpush
