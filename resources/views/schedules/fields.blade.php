@php $timeSlotSelected = isset($schedule) ? $schedule->timeSlots->pluck('id')->toArray() : []; @endphp
<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Tiêu đề:') !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'required', 'maxlength' => 255]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Mô tả:') !!}
    {!! Form::text('description', null, ['class' => 'form-control', 'maxlength' => 255]) !!}
</div>

<!-- Content Field -->
<div class="form-group col-sm-6">
    {!! Form::label('content', 'Nội dung:') !!}
    {!! Form::text('content', null, ['class' => 'form-control', 'maxlength' => 255]) !!}
</div>

<!-- Content Field -->
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('values', 'Thời gian học:') !!}--}}
{{--    {!! Form::text('values', null, ['class' => 'form-control', 'maxlength' => 255]) !!}--}}
{{--</div>--}}

<div class="form-group col-sm-6">
    {!! Form::label('time_slot', 'Khung giờ học:') !!}
    <select name="time_slot[]" class="form-control" multiple id="time_slot">
        <option value>Chọn khung giờ học</option>
        @foreach($timeSlots as $timeSlot)
            <option
                value="{{$timeSlot->id}}" {{in_array($timeSlot->id, $timeSlotSelected) ? 'selected' : ''}}>{{ \App\Helpers\Helper::getDayNameOfWeek($timeSlot->day_of_week)}} {{$timeSlot->start_time}} - {{$timeSlot->end_time}}</option>
        @endforeach
    </select>
</div>

<!-- Course Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('course_id', 'Khoá học:') !!}
    {!! Form::select('course_id', $courses, null, ['class' => 'form-control', 'data-allow-clear' => 'true']) !!}
</div>
<!-- Schedule cha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_id', 'Schedules Cha:') !!}
    <select name="parent_id" class="form-select" style="width: 100%;" id="parent_id">
        <option value>Choose Schedule</option>
        @foreach($schedules as $scheduleItem)
            <option
                value="{{$scheduleItem->id}}" {{isset($schedule) && $scheduleItem->id === $schedule->parent_id ? 'selected' : ''}}>{{ $scheduleItem->title }}</option>
        @endforeach
    </select>
</div>

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_active', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_active', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_active', 'Kích hoạt', ['class' => 'form-check-label']) !!}
    </div>
</div>
