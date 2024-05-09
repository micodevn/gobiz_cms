<?php
/**
 * @var \App\Models\Question $question
 */

$qContent = $question->question_content_parsed;
$explanationVideo = json_encode(Arr::get($qContent, 'explanation_video'));
$explanationVideoId = Arr::get($qContent, 'explanation_video.id');
$explanationVideoUrl = Arr::get($qContent, 'explanation_video.url');
$explanationAudio = json_encode(Arr::get($qContent, 'explanation_audio'));
$explanationAudioId = Arr::get($qContent, 'explanation_audio.id');
$explanationAudioUrl = Arr::get($qContent, 'explanation_audio.url');
$explanationTextValue = Arr::get($qContent, 'explanation_text.value');
$imageId = Arr::get($qContent, 'image.id');
$imageUrl = Arr::get($qContent, 'image.url');
$image = json_encode(Arr::get($qContent, 'image'));
$videoId = Arr::get($qContent, 'video.id');
$videoUrl = Arr::get($qContent, 'video.url');
$video = json_encode(Arr::get($qContent, 'video'));
$audioId = Arr::get($qContent, 'audio.id');
$audioUrl = Arr::get($qContent, 'audio.url');
$audio = json_encode(Arr::get($qContent, 'audio'));
$documentId = Arr::get($qContent, 'document.id');
$documentUrl = Arr::get($qContent, 'document.url');
$document = json_encode(Arr::get($qContent, 'document'));
$text = Arr::get($qContent, 'text.value');
$title = Arr::get($qContent, 'title.value');
$description = Arr::get($qContent, 'description.value');
$explanation = Arr::get($qContent, 'explanation.value');
$selectedTimestamps = $question->videoTimestamps->pluck('id')->toArray();
$assetBundleBlock = Arr::get($qContent, 'asset_bundle_block', []);
$anims = Arr::get($assetBundleBlock, 'animations', []);
$timestamps = [];
$videoDecoded = json_decode($video, true) ?? [];
$videoTimestamps = Arr::get($videoDecoded, 'video_timestamps', []);
$allVideoTimeStamp = Arr::get($qContent, 'all_type_timestamp', false);

if (count($videoTimestamps) > 0) {
    $timestamps = collect($videoTimestamps)->keyBy('id')->map(fn($val) => Arr::get($val, 'title'))->toArray();
}

$mediaTypes = [];

if ($question->platform) {
    $mediaTypes = explode(',', $question->platform->media_types) ?? [];
}
?>
<style>
    .qc-info {
        margin-top: 10px;
    }

    .qc-info .form-group {
        padding-left: 10px;
        flex: 1;
    }

    .card .list-card-bundle {
        display: flex;
        justify-content: space-around;
    }

    .inform_bundle_block {
        display: flex;
        justify-content: space-around;
        margin: 10px auto;
        align-items: center;
    }
</style>
<div class="d-flex py-2 text-center justify-content-center align-items-center" style="background-color: cadetblue">
    <h5 class="card-title">{{__('Question Content')}}</h5>
</div>
<div class="{{$class}}">
    <div>
        <div class="qc-info">
            <div class="row">
                <div class="form-group col-sm-3">
                    {!! Form::label('qc_title', __('models/questions.fields.qc_title').':') !!}
                    {!! Form::text(null, $title, ['rows' => 3, 'id' => 'qc_title', 'class' => 'form-control', 'data-qc-field' => 'title']) !!}
                </div>
                <div class="form-group col-sm-4">
                    {!! Form::label('qc_text', __('models/questions.fields.qc_text').':') !!}
                    {!! Form::textarea(null, $text, ['rows' => 3, 'id' => 'qc_text','class' => 'form-control', 'data-qc-field' => 'text']) !!}
                </div>
                <div class="form-group col-sm-5">
                    {!! Form::label('qc_description', __('models/questions.fields.qc_description').':') !!}
                    {!! Form::textarea(null, $description, ['rows' => 3, 'id' => 'qc_description','class' => 'form-control', 'data-qc-field' => 'description']) !!}
                </div>
            </div>
            <div class="row">
                <div class="form-group mt-2 col-sm-12">
                    <table class="table table-responsive table-striped table-bordered table-hover"
                           id="qc-explanation-table">
                        <thead>
                        <tr>
                            <th colspan="3" class="bg-warning text-white-50">Explanation</th>
                        </tr>
                        <tr>
                            <td>Text</td>
                            <td>Audio</td>
                            <td>Video</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <input value="{{$explanationTextValue}}" type="text" class="form-control"
                                       data-qc-field="explanation_text"
                                       placeholder="Text">
                            </td>
                            <td>
                                <div class="image-selector qc-resource-selector">
                                    <input id="qc-explanation-audio-field" type="hidden" data-qc-field="explanation_audio"
                                           value="{{$explanationAudioId}}">
                                    <button data-file="{{$explanationAudio}}" data-filter-type="audio"
                                            style="width: 150px; height: 150px"
                                            data-file-id="{{$explanationAudioId}}"
                                            id="qc-explanation-audio-selector" type="button" class="file-selector"></button>
                                </div>
                            </td>
                            <td>
                                <div class="qc-resource-selector">
                                    <input id="qc-explanation-video-field" type="hidden" data-qc-field="explanation_video"
                                           value="{{$explanationVideoId}}">
                                    <button data-file="{{$explanationVideo}}" data-filter-type="video"
                                            style="width: 150px; height: 150px"
                                            data-file-id="{{$explanationVideoId}}"
                                            id="qc-explanation-video-selector" type="button" class="file-selector"></button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <hr>
        <div id="accordion">
            {{--      Image      --}}
            <div class="card" id="imageSession" style="{{in_array('IMAGE', $mediaTypes) ? '' : "display: none" }}">
                <div class="card-header" id="collapseImageBtn">
                    <h5 class="mb-0">
                        <button type="button" class="btn btn-primary" data-bs-toggle="collapse"
                                data-bs-target="#collapseImage"
                                aria-expanded="true" aria-controls="collapseImage">
                            <b>Image</b>
                        </button>
                    </h5>
                </div>

                <div id="collapseImage" class="collapse" aria-labelledby="headingOne">
                    <div class="card-body">
                        <div class="image-selector qc-resource-selector">
                            <input id="qc-image-field" type="hidden" data-qc-field="image" value="{{$imageId}}">
                            <button data-file="{{$image}}" data-filter-type="image" style="width: 150px; height: 150px"
                                    data-file-id="{{$imageId}}"
                                    id="qc-image-selector" type="button" class="file-selector"></button>
                        </div>
                    </div>
                </div>
            </div>
            {{--      Video      --}}
            <div class="card" id="videoSession" style="{{in_array('VIDEO', $mediaTypes) ? '' : "display: none" }}">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button type="button" class="btn btn-primary" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne"
                                aria-expanded="true" aria-controls="collapseOne">
                            <b>Video</b>
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
                    <div class="card-body">
                        <div class="video-selector qc-resource-selector mb-3">
                            <b>Video: </b>
                            <input id="qc-video-field" type="hidden" data-qc-field="video" value="{{$videoId}}">
                            <button data-file="{{$video}}" data-filter-type="video" style="width: 150px; height: 150px"
                                    data-file-id="{{$videoId}}"
                                    id="qc-video-selector" type="button" class="file-selector"></button>
                        </div>
                    </div>
                </div>
            </div>
            {{--      Audio      --}}
            <div class="card" id="audioSession" style="{{in_array('AUDIO', $mediaTypes) ? '' : "display: none" }}">
                <div class="card-header" id="collapseAudioBtn">
                    <h5 class="mb-0">
                        <button type="button" class="btn btn-primary" data-bs-toggle="collapse"
                                data-bs-target="#collapseAudio"
                                aria-expanded="true" aria-controls="collapseAudio">
                            <b>Audio</b>
                        </button>
                    </h5>
                </div>

                <div id="collapseAudio" class="collapse" aria-labelledby="collapseAudioBtn">
                    <div class="card-body">
                        <div class="audio-selector qc-resource-selector">
                            <b>Audio: </b>
                            <input id="qc-audio-field" type="hidden" data-qc-field="audio" value="{{$audioId}}">
                            <button data-file="{{$audio}}" data-filter-type="audio" style="width: 150px; height: 150px"
                                    data-file-id="{{$audioId}}"
                                    id="qc-audio-selector" type="button" class="file-selector"></button>
                        </div>
                    </div>
                </div>
            </div>
            {{--      Document      --}}
            <div class="card" id="documentSession"
                 style="{{in_array('DOCUMENT', $mediaTypes) ? '' : "display: none" }}">
                <div class="card-header" id="collapseDocumentBtn">
                    <h5 class="mb-0">
                        <button type="button" class="btn btn-primary" data-bs-toggle="collapse"
                                data-bs-target="#collapseDocument"
                                aria-expanded="true" aria-controls="collapseDocument">
                            <b>Document</b>
                        </button>
                    </h5>
                </div>

                <div id="collapseDocument" class="collapse" aria-labelledby="collapseDocumentBtn">
                    <div class="card-body">
                        <div class="document-selector qc-resource-selector">
                            <b>Document: </b>
                            <input id="qc-document-field" type="hidden" data-qc-field="document"
                                   value="{{$documentId}}">
                            <button data-file="{{$document}}" data-filter-type="pdf" style="width: 150px; height: 150px"
                                    data-file-id="{{$documentId}}"
                                    id="qc-document-selector" type="button" class="file-selector"></button>
                        </div>
                    </div>
                </div>
            </div>
            {{--      Asset Bundle Block      --}}
            {{--            <div class="card" id="bundleSession" style="{{in_array('ASSET_BUNDLE_BLOCK', $mediaTypes) ? '' : "display: none" }}">--}}
            {{--                <div class="card-header" id="collapseAssetBundleBtn">--}}
            {{--                    <h5 class="mb-0">--}}
            {{--                        <button type="button" class="btn btn-primary" data-bs-toggle="collapse"--}}
            {{--                                data-bs-target="#collapseAssetBundle"--}}
            {{--                                aria-expanded="true" aria-controls="collapseAssetBundle">--}}
            {{--                            <b>Asset bundle block</b>--}}
            {{--                        </button>--}}
            {{--                    </h5>--}}
            {{--                </div>--}}

            {{--                <div id="collapseAssetBundle" class="collapse" aria-labelledby="collapseAssetBundleBtn">--}}
            {{--                    <div class="card-body">--}}
            {{--                        <div class="row">--}}
            {{--                            <div class="qc-resource-selector col-3">--}}
            {{--                                <b>Asset bundle IOS: </b>--}}
            {{--                                <input id="qc-asset-bundle-ios-field" type="hidden"--}}
            {{--                                       data-qc-field="asset_bundle_block[ios_id]"--}}
            {{--                                       value="{{Arr::get($assetBundleBlock, 'ios_id')}}">--}}
            {{--                                <button data-file="{{Arr::get($assetBundleBlock, 'ios')}}"--}}
            {{--                                        data-filter-type="asset_bundle"--}}
            {{--                                        data-file-id="{{Arr::get($assetBundleBlock, 'ios_id')}}"--}}
            {{--                                        style="width: 150px; height: 150px"--}}
            {{--                                        id="qc-asset-bundle-ios-selector" type="button" class="file-selector"></button>--}}
            {{--                            </div>--}}
            {{--                            <div class="col-3 qc-resource-selector">--}}
            {{--                                <b>Asset bundle Android: </b>--}}
            {{--                                <input id="qc-asset-bundle-android-field" type="hidden"--}}
            {{--                                       data-qc-field="asset_bundle_block[android_id]"--}}
            {{--                                       value="{{Arr::get($assetBundleBlock, 'android_id')}}">--}}
            {{--                                <button data-file="{{Arr::get($assetBundleBlock, 'android')}}"--}}
            {{--                                        data-filter-type="asset_bundle"--}}
            {{--                                        style="width: 150px; height: 150px"--}}
            {{--                                        data-file-id="{{Arr::get($assetBundleBlock, 'android_id')}}"--}}
            {{--                                        id="qc-asset-bundle-android-selector" type="button"--}}
            {{--                                        class="file-selector"></button>--}}
            {{--                            </div>--}}
            {{--                            <div class="col-3 qc-resource-selector">--}}
            {{--                                <b>Asset bundle WebGl: </b>--}}
            {{--                                <input id="qc-asset-bundle-webgl-field" type="hidden"--}}
            {{--                                       data-qc-field="asset_bundle_block[webgl_id]"--}}
            {{--                                       value="{{Arr::get($assetBundleBlock, 'webgl_id')}}">--}}
            {{--                                <button data-file="{{Arr::get($assetBundleBlock, 'webgl')}}"--}}
            {{--                                        data-filter-type="asset_bundle"--}}
            {{--                                        style="width: 150px; height: 150px"--}}
            {{--                                        data-file-id="{{Arr::get($assetBundleBlock, 'webgl_id')}}"--}}
            {{--                                        id="qc-asset-bundle-webgl-selector" type="button"--}}
            {{--                                        class="file-selector"></button>--}}
            {{--                            </div>--}}
            {{--                            <div class="form-group col-3">--}}
            {{--                                {!! Form::label('config_file_name', 'Config File Name:') !!}--}}
            {{--                                {!! Form::text(null, Arr::get($assetBundleBlock, 'config_file_name'), ['rows' => 3, 'id' => 'config_file_name', 'class' => 'form-control', 'data-qc-field' => 'asset_bundle_block[config_file_name]']) !!}--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                        <hr>--}}
            {{--                        <div class="inform_bundle_block row">--}}
            {{--                            <div class="image-selector qc-resource-selector col-3">--}}
            {{--                                <b>Icon</b>--}}
            {{--                                <input id="qc-asset-icon-field" type="hidden"--}}
            {{--                                       data-qc-field="asset_bundle_block[icon_id]"--}}
            {{--                                       value="{{Arr::get($assetBundleBlock, 'icon_id')}}">--}}
            {{--                                <button data-file="{{Arr::get($assetBundleBlock, 'icon')}}" data-filter-type="image"--}}
            {{--                                        style="width: 100px; height: 100px"--}}
            {{--                                        data-file-id="{{Arr::get($assetBundleBlock, 'icon_id')}}"--}}
            {{--                                        id="qc-asset-icon-selector" type="button" class="file-selector"></button>--}}
            {{--                            </div>--}}
            {{--                            <div class="col-3">--}}
            {{--                                <b>Background: </b>--}}
            {{--                                <input id="qc-asset-background-field" type="hidden"--}}
            {{--                                       data-qc-field="asset_bundle_block[background_id]"--}}
            {{--                                       value="{{Arr::get($assetBundleBlock, 'background')}}">--}}
            {{--                                <button data-file="{{Arr::get($assetBundleBlock, 'background')}}"--}}
            {{--                                        data-filter-type="image"--}}
            {{--                                        style="width: 100px; height: 100px"--}}
            {{--                                        data-file-id="{{Arr::get($assetBundleBlock, 'background')}}"--}}
            {{--                                        id="qc-asset-background-selector" type="button" class="file-selector"></button>--}}
            {{--                            </div>--}}
            {{--                            <div class="form-group col-2">--}}
            {{--                                {!! Form::label('prefab_name', 'Prefab Name:') !!}--}}
            {{--                                {!! Form::text(null, Arr::get($assetBundleBlock, 'prefab_name'), ['rows' => 3, 'id' => 'prefab_name', 'class' => 'form-control', 'data-qc-field' => 'asset_bundle_block[prefab_name]']) !!}--}}
            {{--                            </div>--}}
            {{--                            <div class="form-group col-2">--}}
            {{--                                {!! Form::label('version', 'Version:') !!}--}}
            {{--                                {!! Form::number(null, Arr::get($assetBundleBlock, 'version'), ['rows' => 3, 'id' => 'version', 'class' => 'form-control', 'data-qc-field' => 'asset_bundle_block[version]']) !!}--}}
            {{--                            </div>--}}
            {{--                            <div class="form-group col-2">--}}
            {{--                                {!! Form::label('descriptions', 'Descriptions:') !!}--}}
            {{--                                {!! Form::text(null, Arr::get($assetBundleBlock, 'descriptions'), ['rows' => 3, 'id' => 'descriptions', 'class' => 'form-control', 'data-qc-field' => 'asset_bundle_block[descriptions]']) !!}--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                        <hr>--}}
            {{--                        <label>Animations:</label>--}}
            {{--                        <div class="text-right mb-2">--}}
            {{--                            <button onclick="addAnimRow()" type="button" class="btn btn-outline-secondary btn-sm">+ Add--}}
            {{--                                Anim--}}
            {{--                            </button>--}}
            {{--                        </div>--}}
            {{--                        <table id="anim-table" class="table table-bordered qa-table">--}}
            {{--                            <thead>--}}
            {{--                            <tr>--}}
            {{--                                <td>Anim File</td>--}}
            {{--                                <td>Position</td>--}}
            {{--                                <td width="50px">Action</td>--}}
            {{--                            </tr>--}}
            {{--                            </thead>--}}
            {{--                            <tbody>--}}

            {{--                            </tbody>--}}
            {{--                        </table>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div>
    </div>
</div>
@push('page_scripts')
    <script>

        $( document ).ready(function() {
            loadQuestionContentResource();

            const initChecked = $("#all_type_timestamp").prop('checked');
            initChecked && $("#timestamp-selector").prop('disabled', 'disabled');

            $("#qc-image-selector").on('file-selected', function (e, file) {
                const id = file && file.id ? file.id : null;
                $("#qc-image-field").val(id);
            });
            $("#qc-video-selector").on('file-selected', function (e, file) {
                const id = file && file.id ? file.id : null;
                $("#qc-video-field").val(id);
                $("#qc-video-field").trigger('change');

                loadVideoTimestamps(file);
            });
            $("#qc-audio-selector").on('file-selected', function (e, file) {
                const id = file && file.id ? file.id : null;
                $("#qc-audio-field").val(id);
            });
            $("#qc-document-selector").on('file-selected', function (e, file) {
                const id = file && file.id ? file.id : null;
                $("#qc-document-field").val(id);
            });
            $("#qc-explanation-audio-selector").on('file-selected', function (e, file) {
                const id = file && file.id ? file.id : null;
                $("#qc-explanation-audio-field").val(id);
            });
            $("#qc-explanation-video-selector").on('file-selected', function (e, file) {
                const id = file && file.id ? file.id : null;
                $("#qc-explanation-video-field").val(id);
            });

            $("#qc-asset-icon-selector").on('file-selected', function (e, file) {
                const id = file && file.id ? file.id : null;
                $("#qc-asset-icon-field").val(id);
            });

            $("#qc-asset-background-selector").on('file-selected', function (e, file) {
                const id = file && file.id ? file.id : null;
                $("#qc-asset-background-field").val(id);
            });

            const hasVideo = $("#qc-video-field").val() !== '';
            if (!hasVideo) {
                $("#question-video-timestamps").hide();
            }
            $("#all_type_timestamp").on('click', () => {
                const checkedAllTimestamp = $("#all_type_timestamp").prop('checked');
                checkedAllTimestamp ? $("#timestamp-selector").prop('disabled', 'disabled') : $("#timestamp-selector").prop('disabled', false);
            })
            const element = document.querySelectorAll(`[id^="api-select-"]`);
            $(element).on('select2:select', function (e) {
                const optionSelected = $(this).find('option:selected');
                if (optionSelected.val()) {
                    getInfoParent(optionSelected.val());
                }
            });
        });

        function addAnimRow(animStr = '{}') {
            const tr = $("<tr>");
            const anim = JSON.parse(animStr);

            const animCell = $("<td>");
            const animInput = $("<input/>")
                .attr('type', 'hidden')
                .attr('data-anim', 'file').val(anim.file_id);
            const animButton = $("<button>").css({
                width: '100px',
                height: '100px'
            });
            animButton.attr('type', 'button');
            animButton.attr('data-filter-type', 'asset_bundle');
            animButton.addClass('file-selector').on('file-selected', function (e, file) {
                const input = $(e.target).siblings('input').first();
                $(input).val(file.id);
            });
            animButton.attr('data-file-id', anim.file_id);

            $(animButton).fileSelector();
            if (anim.url) {
                $(animButton).fileSelector('setFile', anim.file_data);
            }
            animCell.append(animButton);
            animCell.append(animInput);
            tr.append(animCell);

            const positionCell = $("<td>").addClass('d-flex').css({
                // width: '200px'
            });
            const positionDiv = $("<div>").addClass('d-flex');
            const xInput = $("<input/>")
                .attr('placeholder', 'x')
                .attr('data-anim', 'posX')
                .addClass('form-control')
                .val(anim.position ? anim.position.x : null);
            const yInput = $("<input/>")
                .attr('placeholder', 'y')
                .attr('data-anim', 'posY')
                .addClass('form-control')
                .val(anim.position ? anim.position.y : null);
            positionDiv.append(xInput);
            positionDiv.append(yInput);
            positionCell.append(positionDiv);
            tr.append(positionCell);

            const actionCell = $("<td>");
            const deleteButton = $("<button>")
                .attr('type', 'button')
                .html('x')
                .addClass('btn btn-small btn-danger')
                .click(function () {
                    tr.remove();
                });
            actionCell.append(deleteButton);
            tr.append(actionCell);

            $("#anim-table").find('tbody').append(tr);
        }

        function loadQuestionContentResource() {
            console.log("loadQuestionContentResource...!");
            const imageUrl = "{{$imageUrl}}";
            const videoUrl = "{{$videoUrl}}";
            const audioUrl = "{{$audioUrl}}";
            const documentUrl = "{{$documentUrl}}";
            const explanationVideoUrl = "{{$explanationVideoUrl}}";
            const explanationAudioUrl = "{{$explanationAudioUrl}}";

            const image = $("#qc-image-selector").attr('data-file');
            const video = $("#qc-video-selector").attr('data-file');
            const audio = $("#qc-audio-selector").attr('data-file');
            const document = $("#qc-document-selector").attr('data-file');
            const explanationVideoId = $("#qc-explanation-video-selector").attr('data-file');
            const explanationAudioId = $("#qc-explanation-audio-selector").attr('data-file');
            //Image
            imageUrl && $("#qc-image-selector").fileSelector('setFile', JSON.parse(image));
            //Video
            videoUrl && $("#qc-video-selector").fileSelector('setFile', JSON.parse(video));
            //Audio
            audioUrl && $("#qc-audio-selector").fileSelector('setFile', JSON.parse(audio));
            //Document
            documentUrl && $("#qc-document-selector").fileSelector('setFile', JSON.parse(document));
            explanationVideoUrl && $("#qc-explanation-video-selector").fileSelector('setFile', JSON.parse(explanationVideoId));
            explanationAudioUrl && $("#qc-explanation-audio-selector").fileSelector('setFile', JSON.parse(explanationAudioId));
        }

        function loadVideoTimestamps(file = null) {
            if ($("#qc-video-field").val() === '') {
                $("#question-video-timestamps").hide();
                return;
            }

            $("#question-video-timestamps").show();

            file = file || $("#qc-video-selector").data('file');
            file = new UploadFile(file);


            const options = file.getTimestampOptions();
            $("#timestamp-selector").empty();
            options.forEach(function (e) {
                $("#timestamp-selector").append(e);
            });
        }

        function getInfoParent(id) {
            axios.get('{{route('question-platform.detail')}}', {
                params: {'id': id}
            })
                .then((response) => {
                    if (!response.data.success) {
                        return;
                    }
                    if (response.data.data.platform) {
                        const listTypeMedia = response.data.data.platform.media_types;

                        // $("#accordion").find('.card').css('display', 'none');

                        listTypeMedia.forEach(function (item) {
                            item === 'IMAGE' && $("#imageSession").css("display", "block");
                            item === 'VIDEO' && $("#videoSession").css("display", "block");
                            item === 'AUDIO' && $("#audioSession").css("display", "block");
                            item === 'DOCUMENT' && $("#documentSession").css("display", "block");
                            // item === 'ASSET_BUNDLE_BLOCK' && $("#bundleSession").css("display", "block");
                        })

                    }
                })
                .catch(function (error) {
                    console.log('error', error)

                })
        }
    </script>
@endpush
