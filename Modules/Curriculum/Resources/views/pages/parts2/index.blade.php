@extends('layouts.app')

@section('content')
    <div class="content">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-header card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Part</h4>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('parts.create') }}" class="btn btn-secondary btn-label waves-effect waves-light">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-plus label-icon align-middle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    Tạo mới
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            @include('curriculum::pages.parts.search_box')

            @include('curriculum::pages.parts.table')
        </div>
    </div>

@endsection
