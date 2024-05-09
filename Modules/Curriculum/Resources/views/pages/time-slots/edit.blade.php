@extends('layouts.app')
@section('content')
    <div class="content">

        @include('adminlte-templates::common.errors')

        <div class="card">
            <div class="card-header card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><b>Sửa khung giờ học</b></h4>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('time-slots.index') }}" class="btn btn-primary"> <i
                                class="fas fa-list pr-2"></i>
                            Danh sách</a>
                    </div>
                </div>
            </div>
            {!! Form::open(['route' => ['time-slots.update.day-of-week', ['dayOfWeek' => $dayOfWeek]], 'method' => 'POST']) !!}
            <div class="card-body">
                <div>
                    <table class="table table-bordered qa-table" id="slot-time-table">
                        <thead>
                        <tr>
                            <th class="w-25">Thứ trong tuần</th>
                            <th>Giờ bắt đầu</th>
                            <th>Giờ kết thúc</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($schedule as $index => $timeSlot)
                            @php $rowSpan = count($schedule);@endphp
                            <input type="hidden" value="{{$timeSlot->id}}" name="time_slot_id[]">
                            <tr class="slot-time-item">
                                @if($index == 0)
                                    <td rowspan="{{$rowSpan}}">
                                        <select name="day_of_week[]" class="form-select" id="day-of-week-0" disabled>
                                            <option value="">Chọn thứ trong tuần</option>
                                            <option value="0" {{$timeSlot->day_of_week == 0 ? 'selected' : ''}}>T2
                                            </option>
                                            <option value="1" {{$timeSlot->day_of_week == 1 ? 'selected' : ''}}>T3
                                            </option>
                                            <option value="2" {{$timeSlot->day_of_week == 2 ? 'selected' : ''}}>T4
                                            </option>
                                            <option value="3" {{$timeSlot->day_of_week == 3 ? 'selected' : ''}}>T5
                                            </option>
                                            <option value="4" {{$timeSlot->day_of_week == 4 ? 'selected' : ''}}>T6
                                            </option>
                                            <option value="5" {{$timeSlot->day_of_week == 5 ? 'selected' : ''}}>T7
                                            </option>
                                            <option value="6" {{$timeSlot->day_of_week == 6 ? 'selected' : ''}}>CN
                                            </option>
                                        </select>
                                    </td>
                                @endif
                                <td>
                                    <input type="text" class="form-control flatpickr flatpickr-input"
                                           name="start_time[]" id="start-time-0" value="{{$timeSlot->start_time}}">
                                </td>
                                <td>
                                    <input type="text" class="form-control flatpickr flatpickr-input"
                                           name="end_time[]"
                                           id="end-time-0" value="{{$timeSlot->end_time}}">
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('time-slots.index') }}" class="btn btn-default"> Cancel </a>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection
@push('page_scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css"/>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script>
        let counter = 1;
        $(function () {
            $(".flatpickr").flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
            });
        });
    </script>
@endpush
