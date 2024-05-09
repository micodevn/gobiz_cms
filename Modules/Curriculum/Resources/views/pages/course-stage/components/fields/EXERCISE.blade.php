@if(isset($oldStages))
    <?php
    $options = collect();

    $unit_id_active = @$item[$program_type_view]['unit_id'];

    $options = $unit_id_active ? DB::table('lesson')->where('unit_id', $unit_id_active)->get() : collect();

    $lesson_ids = @$item[$program_type_view]['lesson_id'];
    ?>
    <div class="col-4 unit-lession-group @if($disabled || !$checkTimeStage) disabled__select @endif">
        <select required name="stage[{{$key_stage-1}}][content][{{$keyRd}}][{{$program_type_view}}][unit_id]"
                class="form-control unit__item__selected">
            <option value=""></option>
            @if(isset($units))
                @foreach($units as $val)
                    <option
                        value="{{$val->id}}" {{@$item[$program_type_view]['unit_id']==$val->id ? 'selected' : '' }}>{{$val->id}}
                        | {{@$val->name}}</option>
                @endforeach
            @endif
        </select>
        <select required name="stage[{{$key_stage-1}}][content][{{$keyRd}}][{{$program_type_view}}][lesson_id][]"
                class="form-control lession__item__selected">
            @foreach($options as $option)
                <option value="{{$option->id}}"
                        @if(in_array($option->id,$lesson_ids)) selected @endif>{{@$option->source}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-2 @if(!$checkTimeStage) disabled__select @endif">
        {!! Form::datetimelocal('stage['.($key_stage-1).'][content]['.$keyRd.']['.$program_type_view.'][start_time_program]', @$item[$program_type_view]['start_time_program'], ['class' => 'form-control' ,'min' => 'today','autocomplete' => 'off']) !!}
    </div>
    <div class="col-2 @if(!$checkTimeStage) disabled__select @endif">
        {!! Form::datetimelocal('stage['.($key_stage-1).'][content]['.$keyRd.']['.$program_type_view.'][end_time_program]', @$item[$program_type_view]['end_time_program'], ['class' => 'form-control', 'min' => 'today','autocomplete' => 'off']) !!}
    </div>
@else
    <?php
    $options = collect();

    if ($timetable_action == 'edit') {
        if (isset($data_field) && !empty($data_field->unit_id)) {
            $unit_id_active = $data_field->unit_id;

            $options = $unit_id_active ? DB::table('lesson')->where('unit_id', $unit_id_active)->get() : collect();

            $lesson_ids = !empty($data_field->lesson_ids) ? json_decode($data_field->lesson_ids) : [];
        }
    } else {


        if (isset($checkGetOldSchedule) && $checkGetOldSchedule) {
            $relationship = $attrGetProgramTyle[$item->program_type]['relationship'];

            $data_field = $item->$relationship;

            $unit_id_active = $data_field->unit_id;

            $options = $unit_id_active ? DB::table('lesson')->where('unit_id', $unit_id_active)->get() : collect();

            $lesson_ids = !empty($data_field->lesson_ids) ? json_decode($data_field->lesson_ids) : [];
        } else {
            $unit_id_active = @$item->unit_id;

            $options = $unit_id_active ? DB::table('lesson')->where('unit_id', $unit_id_active)->get() : collect();

            $lesson_ids = !empty($item->lesson_ids) ? json_decode($item->lesson_ids) : [];
        }


    }
    ?>
    <div class="col-4 unit-lession-group @if($disabled || !$checkTimeStage) disabled__select @endif">
        <select required name="stage[{{$key_stage-1}}][content][{{$keyRd}}][{{$program_type_view}}][unit_id]"
                class="form-control unit__item__selected">
            <option value=""></option>
            @if(isset($units))
                @foreach($units as $val)
                    <option value="{{$val->id}}" {{@$unit_id_active==$val->id ? 'selected' : '' }}>{{$val->id}}
                        | {{@$val->name}}</option>
                @endforeach
            @endif
        </select>
        <select required name="stage[{{$key_stage-1}}][content][{{$keyRd}}][{{$program_type_view}}][lesson_id][]"
                class="form-control lession__item__selected">
            @foreach($options as $option)
                <option value="{{$option->id}}"
                        @if(in_array($option->id,$lesson_ids)) selected @endif>{{@$option->source}}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-2 @if(!$checkTimeStage) disabled__select @endif">
        {!! Form::datetimelocal('stage['.($key_stage-1).'][content]['.$keyRd.']['.$program_type_view.'][start_time_program]', @$item->start_time, ['class' => 'form-control' ,'min' => 'today','autocomplete' => 'off']) !!}
    </div>
    <div class="col-2 @if(!$checkTimeStage) disabled__select @endif">
        {!! Form::datetimelocal('stage['.($key_stage-1).'][content]['.$keyRd.']['.$program_type_view.'][end_time_program]', @$item->end_time, ['class' => 'form-control','min' => 'today','autocomplete' => 'off']) !!}
    </div>
@endif
