@php
    $part = $part ?? new \Modules\Curriculum\Entities\Part();
//    dd($part);
//    $selectedExercises = $part->exercises ?? [];
    $selectedExercises= [];
    $imageSelected = $part?->thumbnail ? [
    'url' => $part?->img_url,
    'name' => 'Search ảnh'
] : [];
    $units = $units ?? [];
@endphp
    <!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Tiêu đề') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 255]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Mô tả') !!}
    {!! Form::text('description', null, ['class' => 'form-control', 'maxlength' => 1000]) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('code', 'Code') !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6 mt-4">
    {!! Form::label('unit_id', 'Unit') !!}
    {!! Form::select('unit_id', $units, null, ['class' => 'form-control no-default api-select']) !!}
</div>
<!-- Type Field -->
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('type', 'Loại part:') !!}--}}
{{--    {!! Form::select('type', \Modules\Curriculum\Entities\Part::PART_TYPES, null, ['class' => 'form-control', 'required']) !!}--}}
{{--</div>--}}

<div class="form-group col-sm-4">
    <div class="mb-3">
        {!! Form::label('thumbnail','Chọn ảnh') !!}
        <x-api-select
            :url="route('api.file.search')"
            name="thumbnail"
            :selected="$imageSelected"
            placeholder="Search ảnh"
            class="file-list select-list"
            value-field="url"
        ></x-api-select>
    </div>
    @if($part->thumbnail)
        <div class="mb-3">
            <div style="width: 170px;height: 170px;">
                <img src="{{ $part->thumbnail }}" alt="" class="img_exam_month pt-1"
                     style="width: 100%;height: 100%;object-fit: contain;background: gray;">
            </div>
        </div>
    @endif
</div>

{{--<div class="form-group col-sm-3">--}}
{{--    {!! Form::label('level', 'Độ khó:') !!}--}}
{{--    {!! Form::select('level', \Modules\Curriculum\Entities\Part::PART_LEVEL, null, ['class' => 'form-control', 'required']) !!}--}}
{{--</div>--}}


<!-- Is Active Field -->
<div class="form-group col-sm-12">
    <div class="form-check">
        {!! Form::hidden('is_active', 0, false) !!}
        {!! Form::checkbox('is_active', 1, $part->is_active, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_active', 'Kích hoạt', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Exercise Field -->
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('exercises', 'Exercise:') !!}--}}
{{--    <x-api-select--}}
{{--        :attributes="['multiple' => 'multiple']"--}}
{{--        :url="route('list-exercises')"--}}
{{--        :selected="$selectedExercises"--}}
{{--        emptyValue=""--}}
{{--        name="exercise_id[]"--}}
{{--        class="exercise_id"--}}
{{--    ></x-api-select>--}}
{{--</div>--}}
