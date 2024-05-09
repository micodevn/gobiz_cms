@extends('layouts.app')
@php
    $package = $package ?? new \Modules\Province\Entities\Province(old());
@endphp
@section('content')
    <div class="content">

        <div class="card">
            {!! Form::model($package, ['route' => ['provinces.store'], 'method' => 'post']) !!}
            <div class="card-body">
                <div class="row">
                    @include('province::pages.provinces.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('provinces.index') }}" class="btn btn-default">
                    @lang('crud.cancel')
                </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
