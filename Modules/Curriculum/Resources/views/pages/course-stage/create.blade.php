@extends('layouts.main')
@section('title')
    Create timeTable
@endsection
@section('page-content')
@include('pages.error')
    <style>
        .header-shedule{
            background-color: lightblue;
            cursor: pointer;
        }
        .unit-lession-group .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice{
            font-size: 11px;
        }
        .ip_holiday{
            width: 1.5rem;
            height: 1.5rem;
        }
        .disabled__select{
            pointer-events: none;
            cursor: not-allowed;
        }

        .disabled__select .select2-selection{
            cursor: not-allowed;
            background-color: #e9ecef !important;
            border-color: #ced4da;
        }
        .select2-selection__clear{
            display: none;
        }
        .box-startTime span.select2{
            width: 50% !important;
        }
        .box-endTime span.select2{
            width: 50% !important;
        }
    </style>
    <div class="card">
        <div class="card-header card-header justify-content-between align-items-center d-flex">
            <h4 class="card-title mb-0">
               Tạo thời khoá biểu
            </h4>
            <h4 class="card-title mb-0">

            </h4>
        </div>
        <form action="{{ route('timetable.store') }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            <div class="card-body row">
                <div class="row col-12">
                    <div class="mb-3 col-6">
                        <label>Tên thời khóa biểu <span class="text-danger">*</span></label>
                        <input value="{{request()->get('name')}}" type="text" class="form-control"
                               name="name"
                               id="name_timetable"
                               required
                               placeholder="_ _ _">
                    </div>
                    <div class="mb-3 col-3 mb-grade">
                        <label>Khối lớp <span class="text-danger">*</span></label>
                        <select id="grade_timetable" onchange="changeGrade($(this))" name="grade" class="form-select" aria-label="Default select example">
                            @foreach($grades as $k=>$v)
                                <option {{request()->get('grade_id') == $v->code ? 'selected' : ''}} value="{{$v->code}}" data-grade="{{@$gradeCode}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-3 mb-grade">
                        <label>Level ( Chương trình Edupia Tutor )<span class="text-danger"></span></label>
                        <select id="pattern_timetable" name="level" class="form-select" aria-label="Trình độ học">
                            <option {{request()->get('level') == null ? 'selected' : ''}} value="">-- Chọn trình độ học --</option>
                            @foreach($level_timetable as $k=>$v)
                                <option {{request()->get('level') == $k ? 'selected' : ''}} value="{{ $k }}">{{ $k }} | {{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-6 mb-grade">
                        <label>Kiểu<span class="text-danger">*</span></label>
                        <select id="pattern_timetable" name="pattern" class="form-select" aria-label="Default select example">
                            @foreach($pattern_timetable as $k=>$v)
                                <option {{request()->get('pattern') == $k ? 'selected' : ''}} value="{{ $k }}">{{ $k }} | {{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-6 mb-grade">
                        <label>Phân loại <span class="text-danger">*</span></label>
                        <select id="type_timetable" required name="type" class="form-select" aria-label="Default select example">
                            @foreach($type_timetable as $key=>$type)
                                <option {{request()->get('type') == $k ? 'selected' : ''}} value="{{$key}}" @if(old('type') == $key) selected @endif>{{$type}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row col-12">
                    <div class="mb-3 col-6">
                        <label>Lộ trình học <span class="text-danger">*</span></label>
                        <select data-placeholder="-- Chọn lộ trình --" required onchange="changeSyllabus($(this))" name="syllabus_id" class="form-select" aria-label="">
                            <option value=""></option>
                            @foreach($list_syllabus as $k=>$v)
                                <option {{request()->get('syllabus_id') == $v->id ? 'selected' : ''}} value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-3 box-startTime">
                        {!! Form::label('start_time','Thời gian bắt đầu') !!} <span class="text-danger">*</span>
                        <div class="input-group mb-3 w-100">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text" id="basic-addon3">28 / 08 /</span>
                            </div>
                            <select data-placeholder="-- Năm --" name="start_timetable" id="start_timetable" class="w-25 form-control">
                                @foreach($year_timetable as $year)
                                    <option
                                        value="{{ $year }}-08-28 00:00:00">
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 col-3 box-endTime">
                        {!! Form::label('end_time','Thời gian kết thúc') !!} <span class="text-danger">*</span>
                        <div class="input-group mb-3 w-100">
                            <div class="input-group-prepend w-50">
                                <span class="input-group-text" id="basic-addon3">27 / 08 /</span>
                            </div>
                            <select data-placeholder="-- Năm --" name="end_timetable" id="end_timetable" class="w-25 form-control">
                                @foreach($year_timetable as $year)

                                    <option
                                        value="{{ $year }}-08-28 00:01:00">
                                        {{ $year }}
                                    </option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @if(count($list_syllabus_detail))
                <div class="list-schedule">
                    @if(old('stage'))
                        @php
                            $oldStages = old('stage');
                        @endphp
                        @foreach($oldStages as $key_st => $stage)
                            @php $key_stage = $key_st+1; @endphp
                            @include('syllabus::pages.timetable.components.stage')
                        @endforeach
                    @else
                        @include('syllabus::pages.timetable.components.stage')
                    @endif
                    <div class="btn btn-sm btn-info btn__add__stage" style="margin-top: -25px;min-width: 80px">Add Stage</div>
                </div>
                @endif
            </div>
            <div class="card-footer">
                @if(\Illuminate\Support\Facades\Auth::user()->isExecuteAllActionSyllabus())
                    <button type="submit" class="btn btn-primary">Save</button>
                @endif
            </div>
        </form>
    </div>
@endsection
@include('syllabus::pages.timetable.components.script')
@push('script')
    <script>
        $("form").submit(function() {
            $(".program-type-option").prop("disabled", false);
            $(".stage-syllabus").prop("disabled", false);
        });

        function changeSyllabus(obj){
            const grade_id = $( "select[name='grade']" ).val();
            window.location.href = '/timetable/create?syllabus_id=' + obj.val() +'&grade_id=' +grade_id + '&name=' + $("#name_timetable").val() + '&grade=' + $("#grade_timetable").val() + '&start_timetable=' + $("#start_timetable").val() + '&end_timetable=' + $("#end_timetable").val() + '&type_timetable=' + $("#type_timetable").val()  + '&pattern_timetable=' + $("#pattern_timetable").val() ;
        }
        function changeGrade(obj){
            const grade_id = obj.find(':selected').val();
            const syllabus_id = $( "select[name='syllabus_id'] option:selected" ).val();
            window.location.href = '/timetable/create?syllabus_id=' + syllabus_id + '&grade_id=' + grade_id + '&name=' + $("#name_timetable").val() + '&grade=' + $("#grade_timetable").val() + '&start_timetable=' + $("#start_timetable").val() + '&end_timetable=' + $("#end_timetable").val() + '&type_timetable=' + $("#type_timetable").val()  + '&pattern_timetable=' + $("#pattern_timetable").val() ;
        }
        function changeHoliday(obj,key){
            let ipAttach = $(`#opt_stage${key}`);

            if(obj.attr('checked') === undefined){
                obj.attr('checked','checked')
                ipAttach.val('1')
            }else{
                obj.removeAttr('checked')
                ipAttach.val('0')
            }
        }
    </script>
@endpush
