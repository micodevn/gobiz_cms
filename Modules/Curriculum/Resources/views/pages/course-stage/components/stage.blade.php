@if(isset($oldStages))
    <?php
    if (isset($stage['syllabus_detail_id']) && count($list_syllabus_detail) == 0) {
        $syllabusDetail = DB::table('syllabus_detail')->find($stage['syllabus_detail_id']);

        if ($syllabusDetail) {
            $list_syllabus_detail = DB::table('syllabus_detail')->where('syllabus_id', $syllabusDetail->syllabus_id)->get();
        }
    }

    // Cho phép sửa dữ liệu của các tuần trước đó
    if (old('check_time_stage') == 1 || config('syllabus.config.edit_timetable_before_time')) {
        $checkTimeStage = true;
    } else {
        $checkTimeStage = false;
    }
    ?>
    <div class="card mt-3 schedule-item" data-key_stage="{{ $key_stage }}">
        <div class="card-header color-edupia header-shedule d-flex justify-content-between align-items-center p-2"
             data-toggle="collapse" href="#collapseScheduleContent_W{{$key_stage}}" aria-expanded="true"
             aria-controls="collapseScheduleContent">
            <h3 class="card-title title-block m-0">Stage {{ $loop->index + 1 }}</h3>
            <span class="d-block float-right"><i class="fas fa-angle-down"></i></span>
            <span class="remove__stage"><i class="fas fa-trash" title="Delete stage"></i></span>
        </div>
        <input type="hidden" value="{{@$schedule->id}}" name="stage[{{$key_stage-1}}][id]">
        <div class="card-body collapse show" id="collapseScheduleContent_W{{$key_stage}}">
            <div class="program__content__item">
                <div>
                    <div class="mb-2 row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Name</label>
                                <select @if(array_key_exists('option',$stage)) disabled @else required
                                        @endif name="stage[{{$key_stage-1}}][syllabus_detail_id]"
                                        class="form-select stage-syllabus stage-syllabus-group"
                                        aria-label="Default select example">
                                    <option value=""></option>
                                    @foreach($list_syllabus_detail as $k=>$v)
                                        <option
                                            {{@$stage['syllabus_detail_id'] == $v->id ? 'selected' : ''}} value="{{$v->id}}">{{$v->week_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2 @if(!$checkTimeStage) disabled__select @endif">
                            <div class="form-group">
                                <label for="">Label</label>
                                <input value="{{@$stage['label']}}" type="text" class="form-control"
                                       name="stage[{{$key_stage-1}}][label]" required placeholder="Tuần X">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group @if(!$checkTimeStage) disabled__select @endif">
                                <label for="">Start time</label>
                                {!! Form::datetimelocal('stage['.($key_stage-1).'][start_time]', @$stage['start_time'], ['class' => 'form-control','required' => 'required' ,'min' => 'today','autocomplete' => 'off']) !!}
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group @if(!$checkTimeStage) disabled__select @endif">
                                <label for="">End time</label>
                                {!! Form::datetimelocal('stage['.($key_stage-1).'][end_time]', @$stage['end_time'], ['class' => 'form-control','required' => 'required' ,'min' => 'today','autocomplete' => 'off']) !!}
                            </div>
                        </div>
                        <div class="col-1 @if(!$checkTimeStage) disabled__select @endif">
                            <div class="form-group checkbox__css">
                                <label>Is Holiday</label>
                                <div class="checkbox-group">
                                    <input type="checkbox" id="html{{$key_stage}}" class="is_holiday"
                                           name="stage[{{$key_stage-1}}][option]" value="1"
                                           @if(array_key_exists('option',$stage)) checked @endif >
                                    <label for="html{{$key_stage}}"></label>
                                </div>
                            </div>
                        </div>
                        @if(!array_key_exists('option',$stage))
                            <div class="stage__content__item">
                                <div class="row mt-2">
                                    <div class="col-3">
                                        <label for="">Loại chương trình</label>
                                    </div>
                                    <div class="col-4">
                                        <label for="">Giá trị</label>
                                    </div>
                                    <div class="col-2">
                                        <label for="">Start time</label>
                                    </div>
                                    <div class="col-2">
                                        <label for="">End time</label>
                                    </div>
                                    <div class="col-1">

                                    </div>
                                </div>
                                <div class="timetable-program-group">
                                    @if(array_key_exists('content',$stage))
                                        @foreach($stage['content'] as $kv => $item)
                                            @php
                                                $program_type_view = array_keys($item)[0];

                                                if(!empty($item[$program_type_view]['syllabus_detail_id'])){
                                                    $disabled = true;
                                                }else{
                                                    $disabled = false;
                                                }
                                            @endphp

                                            @include('syllabus::pages.timetable.components.program-type-old')

                                        @endforeach
                                    @endif

                                </div>
                                <div class="around-add-item-program" style="margin-top: 5px">
                                <span class="add-program-type-stage"
                                      data-sylabus_detail_id="{{@$stage['syllabus_detail_id']}}">
                                    Add program type
                                </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <?php
        // TẠM THỜI BỎ LOGIC check TGIAN
    if ($timetable_action == 'edit') {
        $syllabus_detail_active = $schedule;

        $program_type_syllabus = $schedule->getProgram;

        $syllabus_detail_active_key = 'syllabus_detail_id';

        $is_edit_stage_before = config('syllabus.config.edit_timetable_before_time');

        $checkTimeStage = (time() > strtotime($schedule->end_time) && !$is_edit_stage_before) ? false : true;

    } else {
        $syllabus_detail_active_key = !empty($schedule) ? 'syllabus_detail_id' : 'id';

        $checkTimeStage = true;
    }

    ?>
    <div class="card mt-3 schedule-item" data-key_stage="{{$key_stage}}">
        <div class="card-header color-edupia header-shedule d-flex justify-content-between align-items-center p-2"
             data-toggle="collapse" href="#collapseScheduleContent_W{{$key_stage}}" aria-expanded="true"
             aria-controls="collapseScheduleContent">
            <h3 class="card-title title-block m-0">Stage {{$key_stage}}</h3>
            <span class="d-block float-right"><i class="fas fa-angle-down"></i></span>
            @if($checkTimeStage)
                <span class="remove__stage"><i class="fas fa-trash" title="Delete stage"></i></span>
            @endif
        </div>
        <input type="hidden" value="{{@$schedule->id}}" name="stage[{{$key_stage-1}}][id]" class="schedule__id">
        <input type="hidden" name="check_time_stage" value="{{$checkTimeStage==true ? 1 : 2}}">
        <div class="card-body collapse show" id="collapseScheduleContent_W{{$key_stage}}">
            <div class="program__content__item">
                <div class="mb-2 row">
                    <div class="col-3">
                        <div class="form-group syllabus_detail_group @if(!$checkTimeStage) disabled__select @endif">
                            <label for="">Name</label>
                            <select required @if(@$schedule->option!=null && !isset($activeHoliday)) disabled
                                    @endif name="stage[{{$key_stage-1}}][syllabus_detail_id]"
                                    class="form-select stage-syllabus stage-syllabus-group"
                                    aria-label="Default select example">
                                <option value=""></option>
                                @foreach($list_syllabus_detail as $k=>$v)
                                    <option
                                        {{@$syllabus_detail_active->$syllabus_detail_active_key == $v->id ? 'selected' : ''}} value="{{$v->id}}">{{$v->week_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2 @if(!$checkTimeStage) disabled__select @endif">
                        <div class="form-group">
                            <label for="">Label</label>
                            <input value="{{@$schedule->label}}" type="text" class="form-control"
                                   name="stage[{{$key_stage-1}}][label]" required placeholder="Tuần X">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group @if(!$checkTimeStage) disabled__select @endif">
                            <label for="">Start time</label>
                            {!! Form::datetimelocal('stage['.($key_stage-1).'][start_time]', @$schedule->start_time, ['class' => 'form-control','required' => 'required' ,'min' => 'today','autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group @if(!$checkTimeStage) disabled__select @endif">
                            <label for="">End time</label>
                            {!! Form::datetimelocal('stage['.($key_stage-1).'][end_time]', @$schedule->end_time, ['class' => 'form-control','required' => 'required' ,'min' => 'today','autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group checkbox__css @if(!$checkTimeStage) disabled__select @endif">
                            <label>Is Holiday</label>
                            <div class="checkbox-group">
                                <input type="checkbox" id="html{{$key_stage}}" class="is_holiday"
                                       name="stage[{{$key_stage-1}}][option]" value="1"
                                       @if(@$schedule->option!=null && !isset($activeHoliday)) checked @endif >
                                <label for="html{{$key_stage}}"></label>
                            </div>
                        </div>
                    </div>
                    @if(count($program_type_syllabus))
                        <div class="stage__content__item">
                            <div class="row mt-2">
                                <div class="col-3">
                                    <label for="">Loại chương trình</label>
                                </div>
                                <div class="col-4">
                                    <label for="">Giá trị</label>
                                </div>
                                <div class="col-2">
                                    <label for="">Start time</label>
                                </div>
                                <div class="col-2">
                                    <label for="">End time</label>
                                </div>
                                <div class="col-1">

                                </div>
                            </div>
                            <div class="timetable-program-group">

                                @foreach($program_type_syllabus as $kv => $item)
                                    @php
                                        $program_type_view = $item->program_type;
                                        if(!empty($item->syllabus_detail_id)){
                                            $disabled = true;
                                        }else{
                                        $disabled = false;
                                        }
                                    @endphp

                                    @include('syllabus::pages.timetable.components.program-type')
                                @endforeach

                            </div>
                            @if($checkTimeStage)
                                <div class="around-add-item-program" style="margin-top: 5px">
                                    <button type="button" class="add-program-type-stage"
                                            data-sylabus_detail_id="{{@$syllabus_detail_active->id}}">
                                        Add program type
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
