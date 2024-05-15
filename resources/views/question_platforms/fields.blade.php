<?php
$questionPlatform = $questionPlatform ?? new \App\Models\QuestionPlatform();
//$media_types = $questionPlatform->media_types ? explode(',',$questionPlatform->media_types) : [];
//$selectedParent = [
//    $questionPlatform->parent ? $questionPlatform->parent->toArray() : null
//];

//$hasChildren = $hasChildren ?? false;

//$attributeSelected = $attributeSelectedParent = null;
//
//if ($questionPlatform->attribute_options){
//    $attributeSelected = $questionPlatform->attribute_options;
//}

//if ($questionPlatform->parent) {
//
//    $attributeSelectedParent = $questionPlatform->parent->attribute_options;
//}


//$class = 'platforms_parent';
?>

<!-- Name Field -->
<div class="form-group col-sm-6 mt-4">
    {!! Form::label('name', __('models/questionPlatforms.fields.name').':', ['class' => 'required','required']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}
</div>

<!-- Code Field -->
<div class="form-group col-sm-6 mt-4">
    {!! Form::label('code', __('models/questionPlatforms.fields.code').':', ['class' => 'required','required']) !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6 mt-4">
    {!! Form::label('description', 'Description', ['class' => 'required']) !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Document Link Field -->
{{--<div class="form-group col-sm-12 col-lg-6">--}}
{{--    {!! Form::label('Document Link', __('models/questionPlatforms.fields.doc_link').':', ['class' => 'required']) !!}--}}
{{--    {!! Form::url('doc_link', null, ['class' => 'form-control', 'type' => 'url']) !!}--}}
{{--    <small><i>Document link for this question platform</i></small>--}}
{{--</div>--}}

{{--<!-- Image Id Field -->--}}
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('image_id', __('models/questionPlatforms.fields.image_id').':') !!}--}}
{{--    {!! Form::number('image_id', null, ['class' => 'form-control d-none', 'id' => 'image_id_field', 'data-file' => json_encode($questionPlatform->image)]) !!}--}}
{{--    <button id="image_id" style="width: 150px; height: 150px" class="btn file-selector"--}}
{{--            data-file="{{json_encode($questionPlatform)}}"--}}
{{--            data-file-id="{{$questionPlatform->image_id}}" type="button" data-filter-type="image"></button>--}}
{{--</div>--}}

{{--@if(Auth::user()->isAdmin())--}}
{{--<div class="form-group col-sm-12">--}}
{{--    <x-builder-question-option :attributeOptions="$attributeSelected" :attributeParent="$attributeSelectedParent"></x-builder-question-option>--}}
{{--    <input type="hidden"  name="attribute_options" class="question-attributes">--}}
{{--</div>--}}
{{--@endif--}}


{{--<div class="form-group col-sm-6"  id="media_types">--}}
{{--    {!! Form::label('Danh sách Media Type:') !!}--}}
{{--    <div class="form-check">--}}
{{--        <input class="form-check-input" name="media_types[]" type="checkbox" value="TEXT" id="media_types_text" {{ !$media_types ? 'checked' : (in_array('TEXT',$media_types) ?'checked' : '') }}>--}}
{{--        <label class="form-check-label" for="media_types_text">--}}
{{--            Text--}}
{{--        </label>--}}
{{--    </div>--}}
{{--    <div class="form-check">--}}
{{--        <input class="form-check-input" name="media_types[]" type="checkbox" value="VIDEO" id="media_types_video" {{ !$media_types ? 'checked' : (in_array('VIDEO',$media_types) ?'checked' : '') }}>--}}
{{--        <label class="form-check-label" for="media_types_video">--}}
{{--            Video--}}
{{--        </label>--}}
{{--    </div>--}}
{{--    <div class="form-check">--}}
{{--        <input class="form-check-input" name="media_types[]" type="checkbox" value="IMAGE" id="media_types_image" {{ !$media_types ? 'checked' : (in_array('IMAGE', $media_types) ? 'checked' : '') }}>--}}
{{--        <label class="form-check-label" for="media_types_image">--}}
{{--            Image--}}
{{--        </label>--}}
{{--    </div>--}}
{{--    <div class="form-check">--}}
{{--        <input class="form-check-input" name="media_types[]" type="checkbox" value="AUDIO" id="media_types_asset_audio" {{ !$media_types ? 'checked' : (in_array('AUDIO',$media_types) ? 'checked' : '') }}>--}}
{{--        <label class="form-check-label" for="media_types_asset_audio">--}}
{{--            Audio--}}
{{--        </label>--}}
{{--    </div>--}}
{{--    <div class="form-check">--}}
{{--        <input class="form-check-input" name="media_types[]" type="checkbox" value="DOCUMENT" id="media_types_asset_document" {{ !$media_types ? 'checked' : (in_array('DOCUMENT',$media_types) ? 'checked' : '') }}>--}}
{{--        <label class="form-check-label" for="media_types_asset_document">--}}
{{--            Document--}}
{{--        </label>--}}
{{--    </div>--}}
{{--</div>--}}

<!-- Parent Id Field -->
{{--<div class="form-group col-sm-6" style="{{$hasChildren ? 'display: none' : ''}}">--}}
{{--    {!! Form::label('parent_id', __('models/questionPlatforms.fields.parent_id').':') !!}--}}
{{--    <x-api-select--}}
{{--            :selected="$selectedParent"--}}
{{--            :url="route('question-platform.options')"--}}
{{--            :selectedValue="$questionPlatform->parent_id"--}}
{{--            :selectedLabel="$questionPlatform->parent_name"--}}
{{--            :class="$class"--}}
{{--            emptyValue="root"--}}
{{--            name="parent_id"--}}
{{--    ></x-api-select>--}}
{{--</div>--}}

<!-- 'bootstrap / Toggle Switch Is Active Field' -->
<div class="form-group col-sm-6 mt-4">
    <div>
        {!! Form::label('is_active', __('models/questionPlatforms.fields.is_active').':', []) !!}
    </div>
    {!! Form::hidden('is_active', 0, false) !!}
    {!! Form::checkbox('is_active', 1, $questionPlatform->is_active,  ['data-toggle' => 'toggle']) !!}
</div>

{{--<div class="form-group col-sm-6" id="use_new_platform">--}}
{{--    <div>--}}
{{--        {!! Form::label('use_new_platform', __('models/questionPlatforms.fields.use_new_platform').':', []) !!}--}}
{{--    </div>--}}
{{--    {!! Form::hidden('use_new_platform', 0, false) !!}--}}
{{--    {!! Form::checkbox('use_new_platform', 1, $questionPlatform->use_new_platform,  ['data-toggle' => 'toggle']) !!}--}}
{{--</div>--}}

@push('page_scripts')
{{--    <script src="/storage/js/init-selected-api.js?v={{config('cdn.version_script')}}"></script>--}}
    <script>
        {{--window.addEventListener('DOMContentLoaded', function () {--}}
        {{--    (function ($) {--}}
        {{--        <?php--}}
        {{--            if (!$questionPlatform->parent) {--}}
        {{--                ?>--}}
        {{--                    $("#media_types").hide();--}}
        {{--                    $("#use_new_platform").hide();--}}
        {{--                <?php--}}
        {{--            }--}}
        {{--        ?>--}}
        {{--        $("#image_id").on('file-selected', function(e, file) {--}}
        {{--            const id = file && file.id ? file.id : null;--}}
        {{--            $("#image_id_field").val(id);--}}
        {{--        });--}}
        {{--        const imageId = $("#image_id_field").val();--}}
        {{--        if (imageId) {--}}
        {{--            const data = $("#image_id_field").data('file');--}}
        {{--            $("#image_id").fileSelector('setFile', $("#image_id_field").data('file'));--}}
        {{--        }--}}
        {{--        $(".platforms_parent").on('change', function (e) {--}}
        {{--            if($(".platforms_parent").val()) {--}}
        {{--                $("#use_new_platform").show();--}}
        {{--                $("#media_types").show();--}}
        {{--            }--}}
        {{--        })--}}

        {{--        $("#buttonCollapse").on('click', function (e) {--}}
        {{--            e.preventDefault();--}}
        {{--        })--}}
        {{--    })(jQuery);--}}
        {{--});--}}
    </script>
@endpush

