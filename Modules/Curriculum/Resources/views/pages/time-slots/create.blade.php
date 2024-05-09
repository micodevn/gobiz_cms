@extends('layouts.app')

@section('content')
    <div class="content">

        @include('adminlte-templates::common.errors')

        <div class="card">
            <div class="card-header card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><b>Thêm mới khung giờ học</b></h4>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('time-slots.index') }}" class="btn btn-primary"> <i
                                class="fas fa-list pr-2"></i>
                            Danh sách</a>
                    </div>
                </div>
            </div>
            {!! Form::open(['route' => 'time-slots.store', 'method' => 'POST']) !!}
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
                        <form action="" class="" id="slot-time">
                            <tr class="slot-time-item">
                                <td>
                                    <select name="day_of_week[]" class="form-select" id="day-of-week-0">
                                        <option value="">Chọn thứ trong tuần</option>
                                        <option value="0">T2</option>
                                        <option value="1">T3</option>
                                        <option value="2">T4</option>
                                        <option value="3">T5</option>
                                        <option value="4">T6</option>
                                        <option value="5">T7</option>
                                        <option value="6">CN</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control flatpickr flatpickr-input"
                                           name="start_time[]" id="start-time-0">
                                </td>
                                <td>
                                    <input type="text" class="form-control flatpickr flatpickr-input" name="end_time[]"
                                           id="end-time-0">
                                </td>
                            </tr>
                        </form>

                        </tbody>
                    </table>
                    <div class="text-right mt-2">
                        <button id="btnAddRow" type="button" class="btn btn-outline-secondary">+ khung giờ học
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('parts.index') }}" class="btn btn-default"> Cancel </a>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection
@push('page_scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css"/>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        let counter = 1;
        $(function () {
            $(".flatpickr").flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                defaultDate: "12:00",
                time_24hr: true,
            });
            const slotTimeTable = $('#slot-time-table').DataTable({
                searching: false,
                paging: false,
                ordering: false,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('slot-time-item');
                }
            });
            $('#btnAddRow').on('click', function () {
                let slotTimeSize = $('tr.slot-time-item').length;
                console.log(slotTimeSize)
                slotTimeTable.row.add([
                    `<select name="day_of_week[]" class="form-select" id="day-of-week-${slotTimeSize + 1}">
                    <option value="">Chọn thứ trong tuần</option>
                    <option value="0">T2</option>
                    <option value="1">T3</option>
                    <option value="2">T4</option>
                    <option value="3">T5</option>
                    <option value="4">T6</option>
                    <option value="5">T7</option>
                    <option value="6">CN</option>
            </select>`,
                    `<input type="text" class="form-control flatpickr flatpickr-input" name="start_time[]" id="start-time-${slotTimeSize + 1}">`,
                    `<input type="text" class="form-control flatpickr flatpickr-input" name="end_time[]" id="end-time-${slotTimeSize + 1}">`,
                ]).draw();
                $("#start-time-" + (slotTimeSize + 1)).flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    defaultDate: "12:00",
                    time_24hr: true,
                })
                $("#end-time-" + (slotTimeSize + 1)).flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    defaultDate: "12:00",
                    time_24hr: true,
                });
            });
        });
    </script>
@endpush

