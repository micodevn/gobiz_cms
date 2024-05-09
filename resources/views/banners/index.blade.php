@extends('layouts.app')

@section('content')
    <div class="content">
        @include('flash::message')
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-header card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><b>Banner</b></h4>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('banners.create') }}" class="btn btn-primary"> <i
                                class="fas fa-list pr-2"></i>
                            Thêm mới</a>
                    </div>
                </div>
            </div>
            @include('banners.table')
        </div>
    </div>

@endsection
