@push('page_scripts')
    <script>
        function ClassObject() {
            const _this = this;

            let loading = '<div class="loadingcover">' +
                '<p class="csslder">' +
                '<span class="csswrap">' +
                '<span class="cssdot"></span>' +
                '<span class="cssdot"></span>' +
                '<span class="cssdot"></span>' +
                '</span>' +
                '</p>' +
                '</div>';

            let button_loading = '<i class="fa fa-spinner fa-spin"></i>';

            let base_url = '{{url('/')}}';

            let code = $("select[name='grade'] option:selected").data('grade');

            this.ajaxGetDataAccount = function (url, type = '', parent_el = '', item_el = '', method = 'GET', param = {}, remove = false) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    type: method,
                    url: url,
                    data: param,
                    success: function (response) {
                        if (response.status == true) {
                            if (type == "replace") {
                                $(item_el).replaceWith(response.data);
                                $(item_el).css('opacity', 1);
                                _this.orderStage('.schedule-item');
                            } else if (type == 'add_program_type') {
                                $(parent_el).append(response.data);
                                $(item_el).html('Add program type');
                            } else if (type == 'selected') {
                                $(parent_el).find(item_el).html(response.data);
                            } else if (type == 'add_stage') {
                                $(parent_el).before(response.data);
                                _this.orderStage('.schedule-item');
                                $(parent_el).html('Add stage');
                            } else if (type == 'programtype_detail') {
                                $(parent_el).replaceWith(response.data);
                                _this.orderStage('.schedule-item');
                            } else if (type == 'reset_current_stage') {
                                $(parent_el).replaceWith(response.data);
                                _this.orderStage('.schedule-item');
                            }
                            _this.callSelect2();
                            _this.countStage('.remove__stage');

                        }

                    }

                });
            }

            this.addProgramTypeStage = function (el) {
                $(document).on('click', el, function (e) {

                    e.preventDefault();

                    const item_el = $(this);

                    $(this).html(button_loading);

                    const syllabus_detail_id = $(this).data('sylabus_detail_id');

                    const url = base_url + '/timetable/stage/' + syllabus_detail_id + '/add-program-type';

                    const parent_el = $(this).parents('.schedule-item').find('.timetable-program-group');

                    const countStage = $(this).parents('.schedule-item').data('key_stage');

                    const param = {count_stage: countStage, code: code};

                    _this.ajaxGetDataAccount(url, type = 'add_program_type', parent_el, item_el, method = 'GET', param);

                })
            }

            this.getProgramItemByType = function (el) {
                $(document).on('change', el, function () {

                    const value = this.value;

                    const programID = $(this).parents('.program-item').data('program_id');

                    const countStage = $(this).parents('.schedule-item').data('key_stage');

                    const param = {program_type: value, count_stage: countStage, programID: programID, code: code};

                    const url = base_url + '/program-type/ajax-get-field-by-type';

                    const item_el = $(this).parents('.program-item');

                    item_el.css('opacity', '0.5');

                    _this.ajaxGetDataAccount(url, type = 'replace', parent_el = '', item_el, method = 'GET', param);
                });
            }

            this.unitSelected = function (el_unit, el_lesson) {
                $(document).on('change', el_unit, function (e) {

                    const parent = $(this).parent('.unit-lession-group');

                    const value = this.value;

                    const url = base_url + '/unit/' + value + '/get-lessons';

                    const item_el = $(this).parents('.program-item');

                    _this.ajaxGetDataAccount(url, 'selected', parent, el_lesson, method = 'GET', param = {});
                })
            }

            this.addStageTimeTable = function (el) {
                $(document).on('click', el, function (e) {

                    $('.remove__stage').css('display', 'block');

                    $(this).html(button_loading);

                    const parent = $(this);

                    const countStage = Date.now();

                    const param = {count_stage: countStage, code: code};

                    const value = $("select[name='syllabus_id'] option:selected").val();

                    const url = base_url + '/syllabus/' + value + '/timetable/add-stage';
                    console.log(url)
                    // _this.ajaxGetDataAccount(url, 'add_stage', parent, item_el = '', method = 'GET', param);
                })
            }

            this.getProgramtypeDetail = function (el) {
                $(document).on('change', el, function (e) {

                    $(this).parents('.schedule-item').append(loading);

                    const parent = $(this).parents('.schedule-item');

                    const value = this.value != '' ? this.value : 'holiday';

                    const countStage = parent.data('key_stage');

                    const param = {count_stage: countStage, code: code};

                    const syllabus_id = $("select[name='syllabus_id'] option:selected").val();

                    const url = base_url + '/timetable/syllabus-detail/' + value + '/get-programtype-detail';

                    _this.ajaxGetDataAccount(url, 'programtype_detail', parent, item_el = '', method = 'GET', param);
                })
            }

            this.removeProgramtype = function (el) {
                $(document).on('click', el, function (e) {

                    const parent = $(this).parents('.program-item').remove();

                })
            }

            this.removeStage = function (el) {
                const countStage = $('.schedule-item').length;

                if (countStage < 2) {
                    $(el).css('display', 'none');
                }

                $(document).on('click', el, function () {

                    $(this).parents('.schedule-item').remove();

                    _this.orderStage('.schedule-item');

                    const countProgram = $('.schedule-item').length;

                    if (countProgram == 1) {
                        $(el).css('display', 'none');
                    }
                })
            }

            this.orderStage = function (el) {
                $(el).each(function (key, index) {

                    const stage_name = 'Stage ' + (key + 1);

                    $(this).find('.title-block').html(stage_name);

                });
            }

            this.callSelect2 = function () {
                $('select').not('.no-init').select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: "Search for an Item",
                    allowClear: true,
                });
            }

            this.changeGradeEditTimetable = function (el) {
                $(document).on('change', el, function (e) {
                    const value = $(this).val();

                    window.location.href = '{{url()->current()}}?grade_id=' + value;
                })
            }

            this.holidayChecked = function (el) {
                $(document).on('click', el, function (e) {

                    if ($(this).is(':checked')) {

                        $(this).parents('.program__content__item').find('.stage__content__item').remove();

                        $(this).parents('.program__content__item').find('.stage-syllabus-group option').val("");

                        $(this).parents('.program__content__item').find('.stage-syllabus-group').html('').attr('disabled', 'disabled');

                    } else {

                        $(this).parents('.schedule-item').append(loading);

                        const parent = $(this).parents('.schedule-item');

                        const schedule_id = $(this).parents('.schedule-item').find('.schedule__id').val();

                        const countStage = Date.now();

                        const param = {count_stage: countStage, code: code, schedule_id: schedule_id};

                        const value = $("select[name='syllabus_id'] option:selected").val();

                        const url = base_url + '/syllabus/' + value + '/timetable/add-stage';

                        _this.ajaxGetDataAccount(url, 'reset_current_stage', parent, item_el = '', method = 'GET', param);
                    }
                })


            }

            this.countStage = function (el) {
                const countProgram = $('.schedule-item').length;

                if (countProgram == 1) {
                    $(el).css('display', 'none');
                }
            }
        }

        window.addEventListener('DOMContentLoaded', () => {
            (function ($) {
                console.log("123132");
                let classOj = new ClassObject();

                classOj.addProgramTypeStage('.add-program-type-stage');

                classOj.getProgramItemByType('.program-type-option');

                classOj.unitSelected('.unit__item__selected', '.lession__item__selected');

                classOj.addStageTimeTable('.btn__add__stage');

                classOj.getProgramtypeDetail('.stage-syllabus-group');

                classOj.removeProgramtype('.timetable-remove-item-program-type');

                classOj.removeStage('.remove__stage');

                classOj.changeGradeEditTimetable('#grade_timetable_edit');

                classOj.holidayChecked('.is_holiday');

            })(jQuery);
        });

        $("form").submit(function () {
            $(".program-type-option").prop("disabled", false);
            $(".stage-syllabus").prop("disabled", false);
        });
    </script>
@endpush
