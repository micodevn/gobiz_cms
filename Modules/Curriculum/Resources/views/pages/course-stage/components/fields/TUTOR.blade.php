@if(isset($oldStages))
    <div class="col-4 @if(!$checkTimeStage) disabled__select @endif">
        <select required name="stage[{{$key_stage-1}}][content][{{$keyRd}}][{{$program_type_view}}][tutor_syllabus_id]"
                class="form-control" style="width: 100%;">
            <option value=""></option>
            @foreach($tutor_syllabus as $value)
                <option value="{{@$value['id']}}"
                        @if(@$item[$program_type_view]['tutor_syllabus_id'] == $value['id']) selected @endif>{{@$value['id']. ' | ' . @$value['learn_type']. ' | ' . $value['name']}}</option>
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
    <div class="col-4 @if(!$checkTimeStage) disabled__select @endif">
        <select required name="stage[{{$key_stage-1}}][content][{{$keyRd}}][{{$program_type_view}}][tutor_syllabus_id]"
                class="form-control" style="width: 100%;">
            <option value=""></option>
            @foreach($tutor_syllabus as $val)
                <option value="{{$val['id']}}"
                        @if(@$data_field->tutor_syllabus_id == $val['id']) selected="selected" @endif>{{@$val['id']. ' | ' . @$val['learn_type']. ' | ' . $val['name']}}
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
