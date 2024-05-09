@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tuần học</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('stages.create') }}">
                        Thêm mới
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('stages.table')
        </div>
    </div>

@endsection
