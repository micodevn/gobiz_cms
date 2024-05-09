<?php
$lesson = $lesson ?? new \Modules\Curriculum\Entities\Lesson();
$selectedParts = $lesson->parts ?? collect();
$selectedDocs = $lesson->files ?? collect();
$selectedPartQuestion = $lesson->parts ? $lesson->parts->filter(function ($value, $key) {
    return $value->type == 1;
})->values() : collect();
$selectedPartHomeWork = $lesson->parts->filter(function ($value, $key) {
    return $value->type == 3;
})->values();
$selectedPartQuiz = $lesson->parts ? $lesson->parts->filter(function ($value, $key) {
    return $value->type == 2;
})->values() : collect();
$selectedPartPractice = $lesson->parts ? $lesson->parts->filter(function ($value, $key) {
    return $value->type == 4;
})->values() : collect();
$selectedPartInteraction = $lesson->parts ? $lesson->parts->filter(function ($value, $key) {
    return $value->type == 5;
})->values() : collect();
$imageSelected = $lesson?->thumbnail ? [
    collect([
        'id' => $lesson->thumbnail,
        'url' => $lesson->thumbnail,
        'name' => $lesson->thumbnail
    ])
] : [];
?>

    <!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Tiêu đề:') !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'required', 'maxlength' => 255]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Mô tả:') !!}
    {!! Form::text('description', null, ['class' => 'form-control', 'maxlength' => 1000]) !!}
</div>

<!-- Stage Id Field -->
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('stage_id', 'Tuần học:') !!}--}}
{{--    {!! Form::select('stage_id', $stages, null, ['class' => 'form-control', 'data-allow-clear' => 'true']) !!}--}}
{{--</div>--}}

<!-- Lesson Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Loại buổi học:') !!}
    {!! Form::select('type', \Modules\Curriculum\Entities\Lesson::LESSON_TYPES, null,  ['class' => 'form-control', 'data-allow-clear' => 'true']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('doc_id', 'Tài liệu buổi học:') !!}
    <x-api-select
        :attributes="['multiple' => 'multiple']"
        :url="route('api.file.search')"
        :selected="$selectedDocs"
        placeholder="Tài liệu buổi học"
        name="doc_id[]"
        class="doc_id"
    ></x-api-select>
</div>
<div class="form-group col-sm-4">
    <div class="mb-3">
        {!! Form::label('thumbnail','Chọn ảnh:') !!}
        <x-api-select
            :url="route('api.file.search')"
            name="thumbnail"
            :selected="$imageSelected"
            placeholder="Search ảnh"
            class="file-list select-list"
            value-field="url"
        ></x-api-select>
    </div>
    @if($lesson->thumbnail)
        <div class="mb-3">
            <div style="width: 170px;height: 170px;">
                <img src="{{ $lesson->thumbnail }}" alt="" class="img_exam_month pt-1"
                     style="width: 100%;height: 100%;object-fit: contain;background: gray;">
            </div>
        </div>
    @endif
</div>
<div class="col-12">
    <h4>Nội dung buổi học</h4>
    <div class="row">
        <div class="col-sm-3">
            {!! Form::label('part_quiz','Câu hỏi tính điểm:') !!}
            <x-api-select
                :attributes="['multiple' => 'multiple']"
                :url="route('api.parts.filter')"
                name="part_quiz[]"
                labelField="title"
                :selected="$selectedPartQuiz"
                placeholder="Search Part"
                class="part_quiz"
                :paramsFilterDefault="['type' => 2]"
            ></x-api-select>
        </div>
        <div class="col-sm-3">
            {!! Form::label('part_question','Câu hỏi hiểu bài:') !!}
            <x-api-select
                :attributes="['multiple' => 'multiple']"
                :url="route('api.parts.filter')"
                name="part_question[]"
                labelField="title"
                :selected="$selectedPartQuestion"
                placeholder="Search Part"
                class="part_question"
                :paramsFilterDefault="['type' => 1]"
            ></x-api-select>
        </div>
        <div class="col-sm-3">
            {!! Form::label('part_interaction','Câu hỏi tương tác:') !!}
            <x-api-select
                :attributes="['multiple' => 'multiple']"
                :url="route('api.parts.filter')"
                name="part_interaction[]"
                labelField="title"
                :selected="$selectedPartInteraction"
                placeholder="Search Part"
                class="part_interaction"
                :paramsFilterDefault="['type' => 5]"
            ></x-api-select>
        </div>
    </div>
</div>
<div class="col-12 mt-3">
    <h4>Bài tập về nhà</h4>
    <div class="row">
        <div class="col-sm-3">
            {!! Form::label('part_homework','BTVN:') !!}
            <x-api-select
                :attributes="['multiple' => 'multiple']"
                :url="route('api.parts.filter')"
                name="part_homework[]"
                labelField="title"
                :selected="$selectedPartHomeWork"
                placeholder="Search Part"
                class="part_homework"
                :paramsFilterDefault="['type' => 3]"
            ></x-api-select>
        </div>
        <div class="col-sm-3">
            {!! Form::label('part_practice','Ôn luyện:') !!}
            <x-api-select
                :attributes="['multiple' => 'multiple']"
                :url="route('api.parts.filter')"
                name="part_practice[]"
                labelField="title"
                :selected="$selectedPartPractice"
                placeholder="Search Part"
                class="part_practice"
                :paramsFilterDefault="['type' => 4]"
            ></x-api-select>
        </div>
    </div>
</div>
<!-- Is Active Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_active', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_active', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_active', 'Kích hoạt', ['class' => 'form-check-label']) !!}
    </div>
</div>
