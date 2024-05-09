<?php
$question = $question ?? new \App\Models\Question();
$thumbnailName = $question->getThumbnailUrlAttribute(true);
$selectedPlatform = $question->platform ? [
    [
        'id' => $question->platform->id,
        'name' => $question->platform->name
    ]
] : [];

$selectedProduct = $question->product ? [
    [
        'id' => $question->product->id,
        'name' => $question->product->name
    ]
] : [];

//$question->targetLanguages->each(function (\Modules\AdaptiveLearning\Entities\TargetLanguage $item) {
//    $item->name = $item->getLabel();
//});
$selectedTargetLanguage =  collect();
$listTopics = $listTopics ?? [];
$labelFieldTargetLanguage = 'target_language';
$topicsSelected = $question->topic;
$attributeRender = $question->platform ? json_encode($question->platform->detachAttrOptions()) : false;

$dataFill = [];
$dataFill = json_encode($dataFill);

if ($dataFill) $dataFill = str_replace("'", "\\'\\", $dataFill);
$selectedSyncQuestions = $question->sync ? [
    [
        'id' => $question->sync->id,
        'name' => $question->sync->name
    ]
] : [];
$id_edit = $id_edit ?? '';


$selectedSkillVerb =  [];
$selectedLearning = [];
?>

<style>
    #render_attr .col-form-label {
        background: #6c757d;
        color: white;
        padding: 5px 5px;
        width: 100%;
        margin-bottom: 5px;
    }

    .formio-component-container {
        border-bottom: lightgray thin solid;
    }

    #render_attr .file-selector {
        width: 150px;
        height: 150px;
    }

    /*#render_attr .formio-component-fileSelector{*/
    /*    width: 150px;*/
    /*    display: inline-block;*/
    /*    margin:0 50px;*/
    /*}*/

    /*#render_attr .col-form-label {*/
    /*    background: #4292e7;*/
    /*    color: white;*/
    /*    padding: 5px 5px;*/
    /*    width: 100%;*/
    /*}*/

</style>
{{--<x-learning-objective></x-learning-objective>--}}
{{--<x-questions-exercise-map></x-questions-exercise-map>--}}
{{--<x-response-question-attirbute></x-response-question-attirbute>--}}

<div class="question_pointer"></div>

<div class="d-flex col-sm-12">
    <div class="row" style="flex: 1">
        <!-- Name Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('name', __('models/questions.fields.name').':') !!}
            {!! Form::text('name', null, ['class' => 'form-control','required' => 'required']) !!}
        </div>

        <!-- Short Description Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('description', __('models/questions.fields.description').':') !!}
            {!! Form::text('description', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-sm-3">
            {!! Form::label('duration','Duration:') !!}
            {!! Form::number('duration', null, ['class' => 'form-control']) !!}
        </div>

        <!-- 'bootstrap / Toggle Switch Is Active Field' -->
        <div class="form-group col-sm-6">
            <div>
                {!! Form::label('is_active', __('models/questions.fields.is_active').':', []) !!}
            </div>
            {!! Form::hidden('is_active', 0, false) !!}
            {!! Form::checkbox('is_active', 1, $question->is_active,  ['data-toggle' => 'toggle']) !!}
        </div>
    </div>
</div>

<!-- Interaction Type Field -->
<div class="form-group col-sm-3">
    {!! Form::label('response_interaction_type', __('models/questions.fields.response_interaction_type').':') !!}
    {!! Form::select('response_interaction_type', \App\Models\Question::interactionTypeOptions(), $question->response_interaction_type, ['class' => 'form-control']) !!}
</div>

<!-- Platform Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('platform_id', __('models/questions.fields.platform_id').':') !!}

    <x-api-select
        :url="route('question-platform.group-options')"
        :selectedValue="$question->platform_id"
        :selectedLabel="$question->platform_name"
        :selected="$selectedPlatform"
        emptyValue=""
        name="platform_id"
        class="platformSelect"
    ></x-api-select>
</div>

<!-- Skill Verb Field -->
{{--<div class="form-group col-sm-3">--}}
{{--    {!! Form::label('skill_verb_id', __('models/questions.fields.skill_verb').':') !!}--}}
{{--    <x-api-select--}}
{{--        :url="route('list-skill-verbs')"--}}
{{--        :selected="$selectedSkillVerb"--}}
{{--        emptyValue=""--}}
{{--        name="skill_verb_id"--}}
{{--        class="skillVerb"--}}
{{--    ></x-api-select>--}}
{{--</div>--}}

<!-- Level Field -->
<div class="form-group col-sm-3">
    {!! Form::label('level', __('models/users.fields.level').':') !!}
    {!! Form::hidden('level', '') !!}
    {!! Form::select('level',\App\Models\Question::LEVEL_QUESTIONS,$question->level ?? null, ['class' => 'form-control no-default api-select', 'data-selected' => $question->level]) !!}
</div>

<!-- Platform Id Field -->
{{--<div class="form-group col-sm-12">--}}
{{--    {!! Form::label('target_language_ids', __('models/questions.fields.target_language_ids').':') !!}--}}
{{--    <div class="border rounded">--}}
{{--        <div class="card-body">--}}
{{--            <x-api-select--}}
{{--                :url="route('targetLanguages.list.option')"--}}
{{--                :attributes="['multiple' => 'multiple', 'html-template' => 'html-template']"--}}
{{--                :selected="$selectedTargetLanguage"--}}
{{--                emptyValue=""--}}
{{--                name="target_language_ids[]"--}}
{{--                class="target-language-select"--}}
{{--            ></x-api-select>--}}
{{--        </div>--}}
{{--        <x-target-language class="target_language_new"></x-target-language>--}}
{{--    </div>--}}
{{--</div>--}}

<!-- Topic Field -->
<div class="form-group col-sm-6">
    {!! Form::label('topic_id', __('models/users.fields.topic').':') !!}
    {!! Form::hidden('topic_id', '') !!}
    {!! Form::select('topic_id', $listTopics, null, ['class' => 'form-control no-default api-select', 'data-selected' => $question->topic_id]) !!}
</div>

{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('learning_obj', __('models/exercises.fields.learning_obj').':') !!}--}}
{{--    <div class="d-flex">--}}
{{--        <div class="form-group" style="flex: 1">--}}
{{--            <x-api-select--}}
{{--                :attributes="['multiple' => 'multiple']"--}}
{{--                :url="route('learning.list.option')"--}}
{{--                :selected="$selectedLearning"--}}
{{--                emptyValue=""--}}
{{--                name="learningObj_id[]"--}}
{{--                class="learningObj_id"--}}
{{--            ></x-api-select>--}}
{{--        </div>--}}
{{--        <div>--}}
{{--            <button id="learning_obj" class="btn btn-primary learning_obj" type="button">Tạo mới</button>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="question_attr_origin form-group w-100">
    <!-- Question Content Field -->
    <div class="form-group col-sm-12">
        <x-question-content :question="$question" class="qc-content"></x-question-content>
        <input type="hidden" name="question_content">
    </div>

    <!-- Answers Field -->
    <div class="form-group col-sm-12">
        <x-question-answer :question="$question" class="qa-content"></x-question-answer>
        <input type="hidden" name="answers">
    </div>
</div>


<div id="radar"></div>

@push('page_scripts')
    <script>
        function collectAssetBundle(asset, field, value) {
            return asset[field] = value;
        }

        const recursiveQueryToObject = (query) => {

            const helper = (keys, value, nth) => {
                const key = keys.shift()
                if (!keys.length) return {[key]: value}
                else return {[key]: {...nth[key], ...helper(keys, value, nth[key] || {})}}
            }

            return query.split('&').reduce((result, entry) => {
                const [k, value] = entry.split('=')
                const keys = k.split('.')
                const key = keys.shift()
                result[key] = keys.length ? {...result[key], ...helper(keys, value, result[key] || {})} : value
                return result
            }, {})

        }

        function collectAssetBundleAnim() {
            const table = $("table#anim-table");
            const anims = [];
            table.find('tbody tr').each(function (i, e) {
                const anim = {};
                anim.file_id = $(e).find('[data-anim="file"]').first().val();
                anim.position = {};
                anim.position.x = $(e).find('[data-anim="posX"]').first().val();
                anim.position.y = $(e).find('[data-anim="posY"]').first().val();
                anims.push(anim);
            });

            return anims;
        }

        function collectQCFields() {
            const content = $(".qc-content");
            const fields = content.find('[data-qc-field]');
            const qc_content_data = {};
            let assetBundle = {};
            const resourceFields = [
                'image', 'audio', 'video', 'document', 'explanation_audio', 'explanation_video'
            ];
            const textValueFields = [
                'text', 'title', 'description', 'explanation', 'explanation_text'
            ];
            const assetBundleField = 'asset_bundle_block';
            fields.each(function (i, e) {
                const field = e.getAttribute('data-qc-field');
                const value = FormHelper.getValueByField(e);
                qc_content_data[field] = {};

                if (resourceFields.includes(field)) {
                    qc_content_data[field].id = value;
                    return true;
                }

                if (textValueFields.includes(field)) {
                    qc_content_data[field].value = value;
                    return true;
                }

                if (field.startsWith(assetBundleField)) {
                    const regex = /asset_bundle_block\[(.+)\]/g;
                    const assetF = regex.exec(field)[1];
                    assetBundle[assetF] = value;
                    delete qc_content_data[field];
                    return true;
                }

                qc_content_data[field] = value;
            });
            qc_content_data['all_type_timestamp'] = $('#all_type_timestamp').prop('checked');

            qc_content_data['asset_bundle_block'] = assetBundle;

            qc_content_data['asset_bundle_block'].animations = collectAssetBundleAnim();

            return JSON.stringify(qc_content_data);
        }

        function collectQAFields() {
            const content = $(".qa-content");
            const table = content.find("#qa-table");
            const rows = table.find("tbody tr");
            const qa_content_data = [];

            const resourceFields = [
                'image', 'audio'
            ];
            const textValueFields = [
                'text'
            ];
            const animFields = [
                'anim-File',
                'anim-PosX',
                'anim-PosY'
            ];

            rows.each(function (i, e) {
                const row = $(e);
                const fields = row.find('[data-qa-field]');
                const rowData = {
                    animation: {
                        url: null,
                        id: null,
                        position: {
                            x: 0,
                            y: 0
                        }
                    }
                };
                fields.each(function (i, e) {
                    const field = e.getAttribute('data-qa-field');
                    const value = e.value;

                    if (resourceFields.includes(field)) {
                        rowData[field] = {};
                        rowData[field].id = value;
                    } else if (textValueFields.includes(field)) {
                        rowData[field] = {};
                        rowData[field].value = value;
                    } else if (animFields.includes(field)) {
                        if (field === 'anim-File') {
                            rowData.animation.id = value;
                        }
                        if (field === 'anim-PosX') {
                            rowData.animation.position.x = value;
                        }
                        if (field === 'anim-PosY') {
                            rowData.animation.position.y = value;
                        }
                    } else {
                        rowData[field] = value;
                    }
                });

                qa_content_data.push(rowData);
            });

            return JSON.stringify(qa_content_data);
        }

        function repairedJson(string) {
            return string.replace(/[\u0000-\u0019]+/g, "");
        }

        function renderDataAttr(options, resetRender = false) {
            let render = false;

            @if($attributeRender)
            let attributeRender = {!! $attributeRender !!};
            attributeRender = this.repairedJson(JSON.stringify(attributeRender));
            render = attributeRender ? JSON.parse(attributeRender) : "";
            @endif

            let dataFill = {!! $dataFill !!};
            dataFill = JSON.parse(this.repairedJson(JSON.stringify(dataFill)));

            renderForm.renderDataAttr(render, dataFill, false, 'render_attr');
        }

        function getInfoAttrParent(id) {
            axios.get('{{route('question-platform.detail')}}', {
                params: {'id': id}
            })
                .then((response) => {
                    if (!response.data.success) {
                        return;
                    }
                    if (response.data.data.platform) {
                        const attributeOptions = response.data.data.platform;

                        if (attributeOptions && attributeOptions.attribute_options) {
                            renderForm.renderDataAttr(JSON.parse(attributeOptions.attribute_options));
                        } else {
                            renderForm.renderDataAttr();
                        }
                    }
                })
                .catch(function (error) {
                    console.log('error', error)
                })
        }

        function rebuildSelect2(elem, url) {
            $(elem).select2({
                placeholder: "Search for an Item",
                allowClear: true,
                theme: 'bootstrap4',
                width: '100%',
                ajax: {
                    headers: {
                        'Authorization': 'Bearer ' + API_TOKEN,
                    },
                    url: url,
                    dataType: 'json',
                    quietMillis: 100,
                    delay: 500,
                    data: function (term, page) {
                        return {
                            search: term
                        };
                    },
                    processResults: function (result, page) {
                        let more = result.data.current_page < result.data.last_page;

                        let data = [];

                        if (Array.isArray(result.data)) {
                            data = result.data;
                        }

                        if (result.data && result.data.data && result.data.data.length > 0) {
                            data = $.map(result.data.data, function (obj) {
                                return {id: obj['id'], text: obj['name']};
                            });

                            if (Array.isArray(result.data.data[0].children)) {
                                data = result.data.data;
                                more = false;
                            }
                        }
                        return {
                            results: data,
                            pagination: {
                                more: more
                            }
                        };
                    }
                },
            });
        }

        const fileSelectorObserver = new MutationObserver(function (mutations_list) {
            mutations_list.forEach(function (mutation) {
                mutation.addedNodes.forEach(function (added_node) {
                    if (added_node.classList && added_node.classList.contains('file-selector')) {
                        $(added_node).fileSelector();
                        observer.disconnect();
                    }

                    if ($(added_node)) {
                        $(added_node).find('.file-selector').fileSelector();
                    }
                });
            });
        });

        window.addEventListener('DOMContentLoaded', function () {
            (function ($) {
                renderDataAttr();

                const valueQuestion = document.createElement('input')
                valueQuestion.setAttribute('type', 'hidden');
                valueQuestion.setAttribute('id', 'value-question');
                valueQuestion.value = '{!! $dataFill !!}';
                const renderAttr = document.getElementById('render_attr');
                if (renderAttr) {
                    fileSelectorObserver.observe(document.getElementById('render_attr'), {
                        subtree: true,
                        childList: true
                    })
                }

                const imageId = $("#thumbnail_field").val();
                const form = $(".question_pointer").first().parents('form').first();
                form.append(valueQuestion);
                const new_data = [];
                $("#add_target_input").on('click', (e) => {
                    const part = $("#select_part").find('option:selected').val();

                    if (part && isNaN(part)) {
                        alert("Bạn chưa chọn Part !")
                        return;
                    }
                    new_data.push(
                        {'label': $("#target-input").val(), 'part_id': part, 'explain': $("#explain-input").val()}
                    );

                    $("#target-input").val('')
                    e.preventDefault();
                })

                const element = document.querySelectorAll(`[id^="api-select-"]`);

                $(element).on('change', function (e) {
                    const optionSelected = $(this).find('option:selected');
                    if (optionSelected.val()) {
                        getInfoAttrParent(optionSelected.val());
                    } else {
                        renderForm.renderDataAttr(false)
                    }
                });
                $(".responseExample").attr('data-id-platform', $(".platformSelect").val())

                $(".platformSelect").on('change', function (e) {
                    $(".responseExample").attr('data-id-platform', $(this).val())
                });

                form.on('submit', function (e) {
                    form.find('input[name="question_content"]').first().val(collectQCFields());
                    form.find('input[name="answers"]').first().val(collectQAFields());

                    // custom field
                    const fields = form.find('input[name="answers"]');
                    const newField = $(fields[0]).clone();
                    newField.attr('name', 'new_target_language');
                    newField.insertAfter(fields.last());
                    const data = JSON.stringify(new_data);
                    newField.val(data)

                    const modelTypeField = $('<input/>').attr('type', 'hidden');
                    modelTypeField.attr('name', 'attribute_types');
                    const typeElements = form.find('[data-attribute-type]');
                    const attributeTypes = {};

                    typeElements.each(function (i, e) {
                        const ele = $(e);
                        attributeTypes[ele.attr('name')] = {
                            type: ele.attr('data-attribute-type'),
                            type_option: ele.attr('data-attribute-type-option')
                        };
                    });
                    modelTypeField.val(JSON.stringify(attributeTypes));
                    form.append(modelTypeField);
                });
                let idOnEdit = null;
                @if($id_edit)
                    idOnEdit = {!! $id_edit !!};
                @endif
                if (idOnEdit) {
                    let newUrl = $('.syncQuestion').data('url') + '?currentId=' + idOnEdit;
                    rebuildSelect2('.syncQuestion', newUrl)
                }
            })(jQuery);

        });

    </script>
@endpush
