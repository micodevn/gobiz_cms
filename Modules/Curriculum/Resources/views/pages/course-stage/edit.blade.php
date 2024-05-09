@extends('layouts.main')
@section('title')
    Edit TimeTable
@endsection
@section('css')
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
        .select2-selection__choice{
            background: cornflowerblue;
            color: white !important;
        }
        .disabled__select{
            pointer-events: none;
            cursor: not-allowed;
        }

        .disabled__select .-selection{
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
                <b>{{$info['name']}}</b>
            </h4>
        </div>
        <form action="{{ route('timetable.update',['timetable' => $info['id']]) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            {{ method_field('put') }}
            <div class="card-body row">
                <div class="row col-12">
                    <div class="mb-3 col-6">
                        <label>Tên thời khóa biểu <span class="text-danger">*</span></label>
                        <input value="{{  old('name',$info['name'])  }}" type="text" class="form-control"
                               name="name"
                               id="name_timetable"
                               required
                               placeholder="">
                    </div>
                    <div class="mb-3 col-3 mb-grade">
                        <label>Khối lớp <span class="text-danger">*</span></label>
                        <select required id="grade_timetable_edit" name="grade" class="form-select" aria-label="Default select example">
                            <option value=""></option>
                            @foreach($grades as $k=>$v)
                                <option {{$gradeId == $v->code ? 'selected' : ''}} value="{{$v->code}}" data-grade="{{@$gradeCode}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-3 mb-grade">
                        <label>Level ( Chương trình Edupia Tutor )<span class="text-danger"></span></label>
                        <select id="pattern_timetable" name="level" class="form-select" aria-label="Trình độ học">
                            <option {{request()->get('level') == $k || $info->level == null ? 'selected' : ''}} value="">-- Chọn trình độ học --</option>
                            @foreach($level_timetable as $k=>$v)
                                <option {{request()->get('level') == $k || $info->level == $k ? 'selected' : ''}} value="{{ $k }}">{{ $k }} | {{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-6 mb-grade">
                        <label>Kiểu<span class="text-danger">*</span></label>
                        <select name="pattern" class="form-select" aria-label="Default select example">
                            @foreach($pattern_timetable as $k=>$v)
                                <option {{ $info['pattern'] == $k ? 'selected' : ''}} value="{{ $k }}">{{ $k }} | {{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-6 mb-grade">
                        <label>Phân loại <span class="text-danger">*</span></label>
                        <select required name="type" class="form-select" aria-label="Default select example">
                            <option value=""></option>
                            @foreach($type_timetable as $key=>$type)
                                <option value="{{$key}}" @if($info->type==$key) selected @endif>{{$type}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row col-12">
                    <div class="mb-3 col-6">
                        <label>Lộ trình học <span class="text-danger">*</span></label>
                        <select disabled required name="syllabus_id" class="form-select" aria-label="">
                            <option value=""></option>
                            @foreach($list_syllabus as $k=>$v)
                                <option {{$info['syllabus_id'] === $v->id ? 'selected' : ''}} value="{{$v->id}}">{{$v->name}}</option>
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
                                    @php $valueOption = $year . '-08-28 00:00:00' ; @endphp
                                    <option
                                        value="{{ $valueOption }}"
                                        {{ $info['start_time'] === $valueOption ? 'selected' : '' }}
                                    >
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

                                    @php $valueOption = $year . '-08-28 00:01:00' ; @endphp

                                    <option
                                        value="{{ $valueOption }}"
                                        {{ $info['end_time'] === $valueOption ? 'selected' : '' }}
                                    >
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
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
                        @if(!empty($schedules))
                            @foreach($schedules as $key_schedule => $schedule)
                                @php $key_stage = $key_schedule+1; @endphp
                                @include('syllabus::pages.timetable.components.stage')
                            @endforeach
                        @endif
                    @endif
                    <div class="btn btn-sm btn-info btn__add__stage" style="margin-top: -25px;min-width: 80px">Add Stage</div>
                </div>
            </div>
            @if(\Illuminate\Support\Facades\Auth::user()->isExecuteAllActionSyllabus())
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            @endif
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
