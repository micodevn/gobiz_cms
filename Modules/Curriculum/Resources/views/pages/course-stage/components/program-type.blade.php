<?php
if ($timetable_action == 'edit') {
    $relationship = $attrGetProgramTyle[$item->program_type]['relationship'];

    $data_field = $item->$relationship;

    $timeTable = $schedule->getTimetable;

    $program_id = $item->id;
}
$keyRd = random_int(1000000000, 9999999999999);
?>
<div class="col-12 form-group program-item row mt-2" data-program_id="{{@$program_id}}">
    <div class="col-3">
        <select @if($disabled || !$checkTimeStage) disabled @endif name="program_type[0][]"
                class="form-select program-type-option">
            <option value="">Loại chương trình</option>
            @foreach($program_type as $k=>$v)
                <option value="{{$k}}" @if($program_type_view==$k) selected="selected" @endif>{{$v}}
                </option>
            @endforeach
        </select>
    </div>
    @if($timetable_action=='create')
        <input type="hidden" value="{{@$item->id}}"
               name="stage[{{$key_stage-1}}][content][{{$keyRd}}][{{$program_type_view}}][syllabus_detail_program_type_id]">
        <input type="hidden" value="{{@$item->position}}"
               name="stage[{{$key_stage-1}}][content][{{$keyRd}}][{{$program_type_view}}][position]">
    @else
        <input type="hidden" value="{{@$item->syllabus_detail_program_type_id}}"
               name="stage[{{$key_stage-1}}][content][{{$keyRd}}][{{$program_type_view}}][syllabus_detail_program_type_id]">
        <input type="hidden" value="{{@$item->position}}"
               name="stage[{{$key_stage-1}}][content][{{$keyRd}}][{{$program_type_view}}][position]">
    @endif
    <input type="hidden" value="{{@$item->syllabus_detail_id}}"
           name="stage[{{$key_stage-1}}][content][{{$keyRd}}][{{$program_type_view}}][syllabus_detail_id]">
    <input type="hidden" value="{{@$program_id}}"
           name="stage[{{$key_stage-1}}][content][{{$keyRd}}][{{$program_type_view}}][pro_id]">
    @include('syllabus::pages.timetable.components.fields.'.$program_type_view)
    @if($checkTimeStage)
        <div class="col-sm-1">
            @if($timetable_action=='edit')
                <a target="_blank"
                   href="{{route('program.edit',['program'=> @$item->id,
                                        'time_table_id'=> @$timeTable->id,
                                        'program_type' => @$item->program_type,
                                        'grade_id' => @$timeTable->grade_id])}}"
                   class="btn btn-primary">
                    <i class="fas fa-edit"></i>
                </a>
            @endif
 @if(isset($item) && empty($item->syllabus_detail_id) || isset($check_delete_program_item))
 <button type="button" class="btn btn-danger timetable-remove-item-program-type">X</button>
 @endif
        </div>
    @endif
</div>
