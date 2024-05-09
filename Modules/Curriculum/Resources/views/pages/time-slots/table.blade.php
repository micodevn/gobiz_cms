<div class="card-body p-0">
    <div class="">
        <table class="table table-responsive table-striped table-bordered table-hover" id="time-slots-table">
            <thead class="table-primary">
            <tr>
                <th class="w-25" rowspan="2">Thứ trong tuần</th>
                <th colspan="2">Thời gian</th>
                <th>Thao tác</th>
            </tr>
            <tr>
                <td>Thời gian bắt đầu</td>
                <td>Thời gian kết thúc</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            @foreach($listTimeSlot as $key => $timeSlot)
                @php $rowSpan = count($timeSlot);@endphp
                @foreach($timeSlot as $index => $time)
                    <tr>
                        @if($index == 0)
                            <td rowspan="{{$rowSpan}}">{{\App\Helpers\Helper::getDayNameOfWeek($key)}}</td>
                        @endif
                        <td>
                            {{$time->start_time}}
                        </td>
                        <td>
                            {{$time->end_time}}
                        </td>
                        @if($index == 0)
                            <td rowspan="{{$rowSpan}}"><a class="btn btn-info" href="{{route('time-slots.edit.day-of-week', ['dayOfWeek' => $time->day_of_week])}}">Sửa</a></td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
</div>
