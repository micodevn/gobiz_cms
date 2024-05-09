@extends('layouts.app')

@section('content')
    <div class="content">

        @include('adminlte-templates::common.errors')

        <div class="card">
            <div class="card-header card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><b>Chỉnh sửa lịch học</b></h4>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('schedules.index') }}" class="btn btn-primary"> <i
                                class="fas fa-list pr-2"></i>
                            Danh sách</a>
                    </div>
                </div>
            </div>
            {!! Form::model($schedule, ['route' => ['schedules.update', $schedule->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('schedules.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('schedules.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
@push('page_scripts')
    <script>
        $(document).ready(function () {
            $('#time_slot').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: 'Chọn khung giờ học',
                allowClear: true,
            })
        });
    </script>
@endpush
