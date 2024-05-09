@extends('layouts.app')

@section('content')
    <div class="content">

        @include('adminlte-templates::common.errors')

        <div class="card">
            <div class="card-header card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><b>Tạo mới</b></h4>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('banners.index') }}" class="btn btn-primary"> <i
                                class="fas fa-list pr-2"></i>
                            Danh sách banner</a>
                    </div>
                </div>
            </div>
            {!! Form::open(['route' => 'banners.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('banners.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('banners.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
@push('page_scripts')
    <script src="/storage/js/init-selected-api.js?v={{config('cdn.version_script')}}" defer></script>
    <script>
        let collapse = true;
        let listStageContainerBox = $(".list-stage");
        let stageItemElementClass = '.stage-item';
        let selectLessonType = '.select_lesson_type2';
        let lessonTypeItemClass = '.program-type-item';

        function renderTemplateLessonItem(key) {

        }

        function addType(stageKey) {
            let lessonDetailItem = `
                                            @for($i=0; $i < 1 ; $i++)
            <div class="col-12 row program-type-item mb-2" data-position="${stageKey}">
                                                <div class="col-2 form-group program-item">
                                                    <select required name="program_type[${stageKey}][]"
                                                            class="form-select select_lesson_type2"
                                                            onchange="changeTypeLesson($(this))">
                                                            <option value="">Chọn loại buổi học</option>
                                                            @foreach(\Modules\Curriculum\Entities\Lesson::LESSON_TYPES as $key => $lessonType)
            <option value="{{$key}}">{{$lessonType}}</option>
                                                            @endforeach
            </select>
            </div>
            <div class="col-6 form-group program-item lesson-item">
                <input type="number" class="form-control ip-type" name="" readonly>
                <div class="cpn-lesson" style="display: none">
                    <div class="d-flex box-type-lesson">
                        <select name="lesson_ids[${stageKey}][]" class="form-control lesson-by-unit-${stageKey} lesson-by-unit">
                                                                    <option value=""></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-1 form-group program-item">
                                                        <input type="number" class="form-control" name="position[${stageKey}][]"
                                                               required>
                                                    </div>
                                                    <span onclick="removeProgram($(this))" class="remove-item-program">X</span>
                                                    </div>
                                                    @endfor
            </div>`
            $(`#program-type-parent-${stageKey}`).append(lessonDetailItem)
            reLoadSelect2($(selectLessonType))
        }

        function changeTypeLesson(obj) {
            const lessonType = obj.val();
            obj.parents(lessonTypeItemClass).find('.ip-type').hide()
            obj.parents(lessonTypeItemClass).find('.cpn-lesson').show()
            let selectedLesson = obj.parents(lessonTypeItemClass).find('.cpn-lesson').find('select');
            selectedLesson.attr('required', true)
            reLoadSelect2(selectedLesson);
            reLoadSelect2($(".select-unit"));
            // call api get lesson by
            getLessonByType(obj, lessonType);
        }
        function getLessonByType(unit, lessonType) {
            if(lessonType) {
                let url = '{{ route("api.lessons.filter") }}';
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?= csrf_token() ?>'
                    }
                });
                $.ajax({
                    url: url,
                    data: {
                        type: lessonType
                    },
                    type: 'get',
                    success: function (response) {
                        let options = ``
                        let lessons = response.data.data;
                        for (let i = 0; i < lessons.length; i++) {
                            options += `<option value="${lessons[i].id}">${lessons[i].title}</option>`
                        }
                        let divLesson = unit.parents(lessonTypeItemClass).find('.lesson-item').find('.box-type-lesson').find('.lesson-by-unit');
                        divLesson.html(options)
                        reLoadSelect2(divLesson);
                    },
                    error: function (error) {
                        console.log('error', error)
                    }
                });
            }
            return false;
        }

        function addStage() {
            console.log("add stage");
            let stageKey = listStageContainerBox.find('.stage-item').length;
            let stage = `<div id="stage${stageKey}" class="card mt-3 stage-item" data-position="${stageKey}">
                            <div class="card-header color-edupia header-shedule d-flex justify-content-between align-items-center p-2" data-toggle="collapse" href="#collapseScheduleContent_W${stageKey + 1}" aria-expanded="true" aria-controls="collapseScheduleContent">
                                <h3 class="card-title title-block m-0 pl-2">Stage ${stageKey + 1}</h3>
                                <input type="hidden" name="week[]" value="${stageKey + 1}">
                                <span class="d-block float-right"><i class="fas fa-angle-down"></i></span>
                                <span class="remove__stage" style="display: none;"><i class="fas fa-trash" title="Delete stage"></i></span>
                            </div>
                            <div class="card-body collapse show" id="collapseScheduleContent_W${stageKey + 1}">
                                <div>
                                    <div class="mb-2">
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="">Chọn loại buổi học</label>
                                            </div>
                                            <div class="col-6">
                                                <label for="">Lessons</label>
                                            </div>
                                        </div>
                                        <div id="program-type-parent-${stageKey}" class="row mt-1 lesson-type-list">
                                            @for($i=0; $i < 2 ; $i++)
            <div class="col-12 row program-type-item mb-2" data-position="${stageKey}">
                                                <div class="col-2 form-group program-item">
                                                    <select required name="program_type[${stageKey}][]"
                                                            class="form-select select_lesson_type2"
                                                            onchange="changeTypeLesson($(this))">
                                                            <option value="">Chọn loại buổi học</option>
                                                            @foreach(\Modules\Curriculum\Entities\Lesson::LESSON_TYPES as $key => $lessonType)
            <option value="{{$key}}">{{$lessonType}}</option>
                                                            @endforeach
            </select>
        </div>
        <div class="col-6 form-group program-item lesson-item">
            <input type="number" class="form-control ip-type" name="" readonly>
            <div class="cpn-lesson" style="display: none">
                <div class="d-flex box-type-lesson">
                <select name="lesson_ids[${stageKey}][]" class="form-control lesson-by-unit-${stageKey} lesson-by-unit">
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <span onclick="removeProgram($(this))" class="remove-item-program">X</span>
                                            </div>
                                            @endfor
            </div>
        </div>
    </div>
    <div class="around-add-item-program d-flex justify-content-between">
        <button onclick="addType(${stageKey})" type="button" class="btn btn-secondary btn-addtype btn-sm"> <i class="fas fa-list pr-2"></i>Thêm buổi học</button>
                                                                <button onclick="removeStage(${stageKey})" type="button" class="btn btn-danger mx-4 btn-rm-stage">
                                                                <i class="fa-solid fa-trash pr-2"></i>
                                                                Remove Stage</button>
                                                            </div>
                                                        </div>
                                                    </div>`
            listStageContainerBox.append(stage)
            reLoadSelect2($(selectLessonType));
        }

        function reLoadSelect2(el) {
            el.select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: "Search for an Item",
                allowClear: true,
            })
        }

        function removeProgram(obj) {
            let program = obj.parents(stageItemElementClass)
            if (program.find('.program-type-item').length == 1) {
                alert('Chọn chương trình học !')
                return false;
            } else {
                obj.parents('.program-type-item').remove()
            }
        }

        function collapseStage() {
            if (collapse) {
                $(".card-body.collapse").each(function (i) {
                    $(this).removeClass('show')
                })
            } else {
                $(".card-body.collapse").each(function (i) {
                    $(this).addClass('show')
                })
            }
            collapse = !collapse
        }

        function removeStage(index) {
            if (!confirm('Bạn có chắc chắn muốn xóa stage này ?')) {
                return false;
            }
            // remove
            $(`#stage${index}`).remove()
            // update index in stage
            $('.list-stage ').find('div.stage-item').each(function (i) {
                let _this = $(this)
                _this.attr('id', `stage${i}`);
                _this.attr('data-position', `${i}`);
                _this.find('h3.title-block').html(`Stage ${i + 1}`)
                _this.find('button.btn-rm-stage').attr('onclick', `removeStage(${i})`)
                _this.find('button.btn-addtype').attr('onclick', `addType(${i})`)
                _this.find('div.lesson-type-list').attr('id', `program-type-parent-${i}`)
            });
        }

        function submitCreateSyllabus() {
            let flag = true
            const _stages = $(stageItemElementClass)
            for (let i = 0; i < _stages.length; i++) {
                let ipPosition = $(`input[name='position[${i}][]']`)
                let arrPo = []
                for (let j = 0; j < ipPosition.length; j++) {
                    if (ipPosition[j].value === '' || arrPo.includes(ipPosition[j].value)) {
                        alert('Vị trí hiển thị không được để trống và trùng nhau !')
                        ipPosition[j].focus()
                        flag = false
                        break;
                    }
                    arrPo.push(ipPosition[j].value)
                }
                if (!flag) break;
            }
            return flag;
        }
    </script>
@endpush
