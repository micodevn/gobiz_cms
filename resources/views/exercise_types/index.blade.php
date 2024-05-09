@extends('layouts.app')

@section('content')
    <div class="content">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-header card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><b>Exercise Type</b></h4>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('exercise-types.create') }}" class="btn btn-primary"> <i
                                class="fas fa-list pr-2"></i>
                            Thêm mới</a>
                    </div>
                </div>
            </div>
            <x-filter :filterAble="\App\Models\ExerciseType::filters()"></x-filter>

            <div class="card-body p-0">
                @include('exercise_types.table')

                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', ['records' => $exerciseTypes])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


