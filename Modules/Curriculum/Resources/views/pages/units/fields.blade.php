@php
    $unit = $unit ?? new \Modules\Curriculum\Entities\Unit();
    $imageSelected = $unit?->thumbnail ? [
    collect([
        'id' => $unit->thumbnail,
        'url' => $unit->thumbnail,
    'name' => $unit->thumbnail
    ])
] : [];
    $levels = $levels ?? [];
@endphp
    <!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Tên unit ') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 255]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Mô tả:') !!}
    {!! Form::text('description', null, ['class' => 'form-control', 'maxlength' => 1000, 'required']) !!}
</div>

<div class="form-group col-sm-6 mt-4">
    {!! Form::label('code', 'Unit code') !!}
    {!! Form::text('code', null, ['class' => 'form-control', 'maxlength' => 100, 'required']) !!}
</div>
<div class="form-group col-sm-6 mt-4">
    {!! Form::label('level_id', 'Level') !!}
    {!! Form::select('level_id', $levels, null, ['class' => 'form-control no-default', 'required']) !!}
</div>
<div class="form-group col-sm-6 mt-4">
    {!! Form::label('position', 'Position') !!}
    {!! Form::text('position', null, ['class' => 'form-control', 'maxlength' => 100, 'required']) !!}
</div>
<div class="form-group col-sm-6 mt-4">
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
    @if($unit->thumbnail)
        <div class="mb-3">
            <div style="width: 170px;height: 170px;">
                <img src="{{ $unit->thumbnail }}" alt="" class="img_exam_month pt-1"
                     style="width: 100%;height: 100%;object-fit: contain;background: gray;">
            </div>
        </div>
    @endif
</div>


<!-- Is Active Field -->
<div class="form-group col-sm-12 mt-4">
    <div class="form-check">
        {!! Form::hidden('is_active', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_active', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_active', 'Kích hoạt', ['class' => 'form-check-label']) !!}
    </div>
</div>
@push('page_scripts')
    <script src="{{ asset('storage/js/init-selected-api.js') }}"></script>
    {{--    <script>--}}
    {{--        $.ajaxSetup({--}}
    {{--            headers: {--}}
    {{--                'X-CSRF-TOKEN': '<?= csrf_token() ?>'--}}
    {{--            }--}}
    {{--        });--}}
    {{--        let isLimitLesson = true;--}}
    {{--        let isLessonPrePrimary = {{$isGradePrePrimary}};--}}
    {{--        let scheduleId = '{{count($scheduleSelected) ? $scheduleSelected[0]['id'] : 0}}';--}}
    {{--        let quantityLessonMainInStage = '{{count($scheduleSelected) ? count($scheduleSelected[0]->timeSlots) : 0}}';--}}
    {{--        let listStageContainerBox = $(".list-stage");--}}
    {{--        let stageItemElementClass = '.stage-item';--}}
    {{--        let selectLessonType = '.select_lesson_type2';--}}
    {{--        let lessonTypeItemClass = '.program-type-item';--}}
    {{--        $(function () {--}}
    {{--            $(".scheduleSelected2").on('change', function (e) {--}}
    {{--                const optionSelectedValue = $(this).val();--}}
    {{--                if (optionSelectedValue.length > 0) {--}}
    {{--                    scheduleId = optionSelectedValue[0];--}}
    {{--                    getScheduleDetail(scheduleId)--}}
    {{--                }--}}
    {{--            });--}}
    {{--            $("#gradeSelected2").on('change', function (e) {--}}
    {{--                const optionSelectedValue = $(this).val();--}}
    {{--                // Lớp tiền tiểu học--}}
    {{--                if (parseInt(optionSelectedValue) === 18) {--}}
    {{--                    isLimitLesson = false;--}}
    {{--                    quantityLessonMainInStage = 100;--}}
    {{--                    isLessonPrePrimary = true;--}}
    {{--                }--}}
    {{--            });--}}
    {{--        })--}}
    {{--        function uuid() {--}}
    {{--            let temp_url = URL.createObjectURL(new Blob());--}}
    {{--            let uuid = temp_url.toString();--}}
    {{--            URL.revokeObjectURL(temp_url);--}}
    {{--            return uuid.substr(uuid.lastIndexOf('/') + 1); // remove prefix (e.g. blob:null/, blob:www.test.com/, ...)--}}
    {{--        }--}}
    {{--        function changeTypeLesson(obj) {--}}
    {{--            const lessonType = $(obj).val();--}}
    {{--            obj.parents(lessonTypeItemClass).find('.ip-type').hide()--}}
    {{--            obj.parents(lessonTypeItemClass).find('.cpn-lesson').show()--}}
    {{--            let selectedLesson = obj.parents(lessonTypeItemClass).find('.cpn-lesson').find('select');--}}
    {{--            selectedLesson.attr('required', true)--}}
    {{--            reLoadSelect2(selectedLesson);--}}
    {{--            reLoadSelect2($(".select-unit"));--}}
    {{--            getLessonByType(obj, lessonType);--}}
    {{--        }--}}

    {{--        function getLessonByType(unit, lessonType) {--}}
    {{--            if (lessonType) {--}}
    {{--                let url = '{{ route("api.lessons.filter") }}';--}}
    {{--                $.ajax({--}}
    {{--                    url: url,--}}
    {{--                    data: {--}}
    {{--                        type: lessonType--}}
    {{--                    },--}}
    {{--                    type: 'get',--}}
    {{--                    success: function (response) {--}}
    {{--                        let options = `<option value="">Chọn bài học</option>`--}}
    {{--                        let lessons = response.data.data;--}}
    {{--                        for (let i = 0; i < lessons.length; i++) {--}}
    {{--                            options += `<option value="${lessons[i].id}">${lessons[i].id} | ${lessons[i].title}</option>`--}}
    {{--                        }--}}
    {{--                        let divLesson = unit.parents(lessonTypeItemClass).find('.lesson-item').find('.box-type-lesson').find('.lesson-by-unit');--}}
    {{--                        divLesson.html(options)--}}
    {{--                        reLoadSelect2(divLesson);--}}
    {{--                    },--}}
    {{--                    error: function (error) {--}}
    {{--                        console.log('error', error)--}}
    {{--                    }--}}
    {{--                });--}}
    {{--            }--}}
    {{--            return false;--}}
    {{--        }--}}

    {{--        function addType(stageKey) {--}}
    {{--            let countMainLesson = $(`#program-type-parent-${stageKey}`).find('.program-type-item-main');--}}
    {{--            let lessonDetailItem = '';--}}
    {{--            if(isLessonPrePrimary) {--}}
    {{--                lessonDetailItem = renderSelectedLesson(stageKey);--}}
    {{--            } else {--}}
    {{--                if (countMainLesson.length < quantityLessonMainInStage) {--}}
    {{--                    lessonDetailItem = renderSelectedLesson(stageKey);--}}
    {{--                } else {--}}
    {{--                    lessonDetailItem = `--}}
    {{--                                <div class="col-12 row program-type-item program-type-item-extra program-type-item-extra-new mb-2" data-position="${stageKey}">--}}
    {{--                                    <div class="col-2 form-group program-item">--}}
    {{--                                        <select required name="program_type[${stageKey}][]"--}}
    {{--                                                class="form-select select_lesson_type2"--}}
    {{--                                                onchange="changeTypeLesson($(this))">--}}
    {{--                                                    <option value="2" selected="selected">{{\Modules\Curriculum\Entities\Lesson::LESSON_TYPES[2]}}</option>--}}
    {{--                                        </select>--}}
    {{--                                    </div>--}}
    {{--                                    <div class="col-6 form-group program-item lesson-item">--}}
    {{--                                        <input type="number" class="form-control ip-type" name="" readonly>--}}
    {{--                                        <div class="cpn-lesson" style="display: none">--}}
    {{--                                            <div class="d-flex box-type-lesson">--}}
    {{--                                                <select name="lesson_ids[${stageKey}][]" class="form-control lesson-by-unit-${stageKey} lesson-by-unit">--}}
    {{--                                                    <option value=""></option>--}}
    {{--                                                </select>--}}
    {{--                                            </div>--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                        <span onclick="removeProgram($(this))" class="remove-item-program">X</span>--}}
    {{--                                    </div>`--}}
    {{--                }--}}
    {{--            }--}}

    {{--            $(`#program-type-parent-${stageKey}`).append(lessonDetailItem)--}}
    {{--            let listSelectedLessonElement = $(`#program-type-parent-${stageKey}`).children('.program-type-item-main-new').find('select.select_lesson_type2');--}}
    {{--            let listSelectedLessonExtraElement = $(`#program-type-parent-${stageKey}`).children('.program-type-item-extra-new').find('select.select_lesson_type2');--}}
    {{--            if (listSelectedLessonElement.length) {--}}
    {{--                listSelectedLessonElement.each((index, obj) => {--}}
    {{--                    reLoadSelect2($(obj))--}}
    {{--                    return changeTypeLesson($(obj))--}}
    {{--                })--}}
    {{--            }--}}
    {{--            if (listSelectedLessonExtraElement.length) {--}}
    {{--                listSelectedLessonExtraElement.each((index, obj) => {--}}
    {{--                    reLoadSelect2($(obj))--}}
    {{--                    return changeTypeLesson($(obj))--}}
    {{--                })--}}
    {{--            }--}}
    {{--        }--}}

    {{--        function addStage() {--}}
    {{--            if (!scheduleId) {--}}
    {{--                return false;--}}
    {{--            }--}}
    {{--            let stageKey = listStageContainerBox.find('.stage-item').length;--}}
    {{--            let stage = `<div id="stage${stageKey}" class="card mt-3 stage-item" data-position="${stageKey}">--}}
    {{--                            <div class="card-header color-edupia header-shedule d-flex justify-content-between align-items-center p-2" data-toggle="collapse" href="#collapseScheduleContent_W${stageKey + 1}" aria-expanded="true" aria-controls="collapseScheduleContent">--}}
    {{--                                <input type="hidden" name="week[]" value="${uuid()}">--}}
    {{--                                <div class="row form-group w-75">--}}
    {{--                                    <div class="col-2">--}}
    {{--                                        <span>Id: ${stageKey + 1}</span>--}}
    {{--                                    </div>--}}
    {{--                                    <div class="col-2">--}}
    {{--                                        <label for="stageTitle${stageKey + 1}">Tên Stage / Topic: </label>--}}
    {{--                                    </div>--}}
    {{--                                    <div class="col-5">--}}
    {{--                                        <input type="text" class="form-control" name="title_stage[]" id="stageTitle${stageKey + 1}"--}}
    {{--                                               value="" placeholder="Tên topic/stage">--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                        <div>--}}
    {{--                                            <span class="d-block float-right"><i class="fas fa-angle-down"></i></span>--}}
    {{--                                        </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="card-body collapse show" id="collapseScheduleContent_W${stageKey + 1}">--}}
    {{--                                <div>--}}
    {{--                                    <div class="mb-2">--}}
    {{--                                        <div class="row">--}}
    {{--                                            <div class="col-2">--}}
    {{--                                                <label for="">Chọn loại buổi học</label>--}}
    {{--                                            </div>--}}
    {{--                                            <div class="col-6">--}}
    {{--                                                <label for="">Lessons</label>--}}
    {{--                                            </div>--}}
    {{--                                        </div>--}}
    {{--                                        <div id="program-type-parent-${stageKey}" class="row mt-1 lesson-type-list">--}}
    {{--                                            ${renderSelectedLesson(stageKey)}--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--            <div class="around-add-item-program d-flex justify-content-between">--}}
    {{--                        <button onclick="addType(${stageKey})" type="button" class="btn btn-secondary btn-addtype btn-sm"> <i class="fas fa-list pr-2"></i>Thêm buổi học</button>--}}
    {{--                        <button onclick="removeStage(${stageKey})" type="button" class="btn btn-danger mx-4 btn-rm-stage">--}}
    {{--                        <i class="fa-solid fa-trash pr-2"></i>--}}
    {{--                        Remove Stage</button>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--                            </div>--}}
    {{--                        </div>`--}}
    {{--            listStageContainerBox.append(stage)--}}
    {{--            let listSelectedLessonElement = $(listStageContainerBox).find(`#stage${stageKey}`).find('select.select_lesson_type2');--}}
    {{--            if (listSelectedLessonElement.length) {--}}
    {{--                listSelectedLessonElement.each((index, obj) => {--}}
    {{--                    reLoadSelect2($(selectLessonType));--}}
    {{--                    return changeTypeLesson($(obj))--}}
    {{--                })--}}
    {{--            }--}}
    {{--        }--}}

    {{--        function renderSelectedLesson(stageKey) {--}}
    {{--            console.log("isLessonPrePrimary: ", isLessonPrePrimary);--}}
    {{--            let htmlContent = '';--}}
    {{--            let countMainLesson = $(`#program-type-parent-${stageKey}`).find('.program-type-item-main');--}}
    {{--            if(isLessonPrePrimary) {--}}
    {{--                htmlContent += `<div class="col-12 row program-type-item program-type-item-main program-type-item-main-new mb-2" data-position="${stageKey}">--}}
    {{--                                    <div class="col-2 form-group program-item">--}}
    {{--                                        <select required name="program_type[${stageKey}][]"--}}
    {{--                                            class="form-select select_lesson_type2">--}}
    {{--                                            <option value="3" selected="selected">{{\Modules\Curriculum\Entities\Lesson::LESSON_TYPES[3]}}</option>--}}
    {{--                                        </select>--}}
    {{--                                    </div>--}}
    {{--                                    <div class="col-6 form-group program-item lesson-item">--}}
    {{--                                        <input type="number" class="form-control ip-type" name="" readonly>--}}
    {{--                                        <div class="cpn-lesson" style="display: none">--}}
    {{--                                            <div class="d-flex box-type-lesson">--}}
    {{--                                            <select name="lesson_ids[${stageKey}][]" class="form-control lesson-by-unit-${stageKey} lesson-by-unit">--}}
    {{--                                                <option value=""></option>--}}
    {{--                                            </select>--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <span onclick="removeProgram($(this))" class="remove-item-program">X</span>--}}
    {{--                            </div>`--}}
    {{--            } else {--}}
    {{--                if (isLimitLesson) {--}}
    {{--                    for (let i = countMainLesson.length; i < quantityLessonMainInStage; i++) {--}}
    {{--                        htmlContent += `<div class="col-12 row program-type-item program-type-item-main program-type-item-main-new mb-2" data-position="${stageKey}">--}}
    {{--                                    <div class="col-2 form-group program-item">--}}
    {{--                                        <select required name="program_type[${stageKey}][]"--}}
    {{--                                            class="form-select select_lesson_type2">--}}
    {{--                                            <option value="1" selected="selected">{{\Modules\Curriculum\Entities\Lesson::LESSON_TYPES[1]}}</option>--}}
    {{--                                        </select>--}}
    {{--                                    </div>--}}
    {{--                                    <div class="col-6 form-group program-item lesson-item">--}}
    {{--                                        <input type="number" class="form-control ip-type" name="" readonly>--}}
    {{--                                        <div class="cpn-lesson" style="display: none">--}}
    {{--                                            <div class="d-flex box-type-lesson">--}}
    {{--                                            <select name="lesson_ids[${stageKey}][]" class="form-control lesson-by-unit-${stageKey} lesson-by-unit">--}}
    {{--                                                <option value=""></option>--}}
    {{--                                            </select>--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>`--}}
    {{--                    }--}}
    {{--                } else {--}}
    {{--                    htmlContent += `<div class="col-12 row program-type-item program-type-item-main program-type-item-main-new mb-2" data-position="${stageKey}">--}}
    {{--                                    <div class="col-2 form-group program-item">--}}
    {{--                                        <select required name="program_type[${stageKey}][]"--}}
    {{--                                            class="form-select select_lesson_type2">--}}
    {{--                                            <option value="1" selected="selected">{{\Modules\Curriculum\Entities\Lesson::LESSON_TYPES[1]}}</option>--}}
    {{--                                        </select>--}}
    {{--                                    </div>--}}
    {{--                                    <div class="col-6 form-group program-item lesson-item">--}}
    {{--                                        <input type="number" class="form-control ip-type" name="" readonly>--}}
    {{--                                        <div class="cpn-lesson" style="display: none">--}}
    {{--                                            <div class="d-flex box-type-lesson">--}}
    {{--                                            <select name="lesson_ids[${stageKey}][]" class="form-control lesson-by-unit-${stageKey} lesson-by-unit">--}}
    {{--                                                <option value=""></option>--}}
    {{--                                            </select>--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <span onclick="removeProgram($(this))" class="remove-item-program">X</span>--}}
    {{--                            </div>`--}}
    {{--                }--}}
    {{--            }--}}

    {{--            return htmlContent;--}}
    {{--        }--}}

    {{--        function reLoadSelect2(el) {--}}
    {{--            el.select2({--}}
    {{--                theme: 'bootstrap4',--}}
    {{--                width: '100%',--}}
    {{--                placeholder: "Search for an Item",--}}
    {{--                allowClear: true,--}}
    {{--            })--}}
    {{--        }--}}

    {{--        function removeProgram(obj) {--}}
    {{--            let program = obj.parents(stageItemElementClass)--}}
    {{--            if (program.find('.program-type-item').length == 1) {--}}
    {{--                alert('Chọn chương trình học !')--}}
    {{--                return false;--}}
    {{--            } else {--}}
    {{--                obj.parents('.program-type-item').remove()--}}
    {{--            }--}}
    {{--        }--}}

    {{--        function collapseStage() {--}}
    {{--            if (collapse) {--}}
    {{--                $(".card-body.collapse").each(function (i) {--}}
    {{--                    $(this).removeClass('show')--}}
    {{--                })--}}
    {{--            } else {--}}
    {{--                $(".card-body.collapse").each(function (i) {--}}
    {{--                    $(this).addClass('show')--}}
    {{--                })--}}
    {{--            }--}}
    {{--            collapse = !collapse--}}
    {{--        }--}}

    {{--        function removeStage(index) {--}}
    {{--            if (!confirm('Bạn có chắc chắn muốn xóa stage này ?')) {--}}
    {{--                return false;--}}
    {{--            }--}}
    {{--            // remove--}}
    {{--            $(`#stage${index}`).remove()--}}
    {{--            // update index in stage--}}
    {{--            $('.list-stage ').find('div.stage-item').each(function (i) {--}}
    {{--                let _this = $(this)--}}
    {{--                _this.attr('id', `stage${i}`);--}}
    {{--                _this.attr('data-position', `${i}`);--}}
    {{--                _this.find('h3.title-block').html(`Stage ${i + 1}`)--}}
    {{--                _this.find('button.btn-rm-stage').attr('onclick', `removeStage(${i})`)--}}
    {{--                _this.find('button.btn-addtype').attr('onclick', `addType(${i})`)--}}
    {{--                _this.find('div.lesson-type-list').attr('id', `program-type-parent-${i}`)--}}
    {{--            });--}}
    {{--        }--}}

    {{--        function getScheduleDetail(scheduleId) {--}}
    {{--            axios.get("/api/schedules/" + scheduleId)--}}
    {{--                .then((response) => {--}}
    {{--                    if (!response.data.success) {--}}
    {{--                        return;--}}
    {{--                    } else {--}}
    {{--                        if (response.data.data.time_slots) {--}}
    {{--                            if (response.data.data.time_slots.length > quantityLessonMainInStage) {--}}
    {{--                                quantityLessonMainInStage = response.data.data.time_slots.length;--}}
    {{--                            }--}}
    {{--                        }--}}
    {{--                    }--}}
    {{--                })--}}
    {{--                .catch(function (error) {--}}
    {{--                    console.log("getScheduleDetail error: ", error)--}}
    {{--                })--}}
    {{--                .then(() => {--}}
    {{--                });--}}
    {{--        }--}}
    {{--    </script>--}}
@endpush
