<?php
$baseUrl = config('app.url', 'https://cms-core.edupia.vn/');
?>
<style>
    .container {
        padding: 2rem 0rem;
    }

    h4 {
        margin: 2rem 0rem 1rem;
    }

    .table-image td, th {
        vertical-align: middle;
    }

    .list-view {
        overflow-y: scroll;
        height: 100%;
    }

    .modal.modal-fullscreen .modal-dialog {
        width: 100vw;
        height: 100vh;
        margin: 0;
        padding: 0;
        max-width: none;
    }

    .modal.modal-fullscreen .modal-content {
        /*height: auto;*/
        height: 100vh;
        border-radius: 0;
        border: none;
    }

    .verticalLine {
        border-left: thick solid #ff0000;
    }

    .verticalLine {
        border-left: 1px solid gray;
    }


    /* Important part */
    .modal-dialog {
        overflow-y: initial !important
    }

    .modal-body {
        height: 80vh;
        overflow-y: auto;
    }

</style>

<div class="modal fade modal-fullscreen questionExerciseModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="d-flex flex-row">
                <div class="p-2 modal-body" style="flex: 1;max-height: 90%">
                    <h5 class="modal-title text-center w-75">Selected Questions</h5>
                    <table id="table_id" class="table table-triped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th scope="col" class="w-30">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="list-view">
                        <tr class="d-none">
                            <td class="question-id">1</td>
                            <td class="question-name">how are you</td>
                            <td>
                                <div class="d-flex w-100 float-right">
                                    <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; flex: 1">
                                        <a href="javascript:void(0)" class="up">Up</a>
                                        <a href="javascript:void(0)" class="down">Down</a>
                                    </div>
                                    <button type="button" class="btn btn-danger removeRow">x</button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="verticalLine"></div>
                <div class="p-1" style="flex: 2">
                    <h5 class="modal-title text-center">Choice Questions</h5>
                    <div class="col-12 row pt-2">
                        <div class="form-group mb-0 col-1">
                            <div class="form-group">
                                <input placeholder="ID" name="id" id="question-id-search" type="number" min="0"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-0 col-2">
                            <div class="form-group">
                                <input placeholder="Name or Description" name="name" id="question-name-search"
                                       type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-0 col-2">
                            <div class="form-group">
                                <select name="class_id" id="question-class-search" data-placeholder="Search for class">
                                    <option></option>
                                    @foreach(\App\Models\Question::CLASS_INFO as $key => $val)
                                        <option {{request()->get('class_id') == $key ? "selected='selected'" : '' }} value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-0 col-2">
                            <div class="form-group">
                                <x-api-select
                                        :attributes="['multiple' => 'multiple']"
                                        :url="route('question-platform.group-options')"
                                        emptyValue=""
                                        name="platforms[]"
                                        placeholder="Search Platform"
                                        class="question-platformSelect-search"
                                ></x-api-select>
                            </div>
                        </div>

                        <div class="form-group mb-0 col-2">
                            <div class="form-group">
                                <select name="level" id="question-level-search" data-placeholder="Search Level"
                                        class="level">
                                    <option></option>
                                    @foreach(\App\Models\Question::LEVEL_QUESTIONS as $key => $val)
                                        <option {{request()->get('level') == $key ? "selected='selected'" : '' }} value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-0 col-2">
                            <div class="form-group">
                                <select class="form-control select2bs4" name="is_used_search" id="is_used_search"
                                        data-placeholder="is in used" style="width: 100%;">
                                    <option></option>
                                    <option {{request()->get('is_used_search') === '1' ? 'selected' : ''}} value="1">
                                        used
                                    </option>
                                    <option {{request()->get('is_used_search') === '-1' ? 'selected' : ''}} value="-1">
                                        available
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-0 col-1 p-0">
                            <button type="submit" class="btn question-search-form"><i class="fas fa-search"></i>
                                <span class="search-filter-text">Search</span>
                            </button>
                        </div>
                    </div>
                    <table class="table" id="questionTable">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Platform</th>
                            <th scope="col">Level</th>
                            <th scope="col">Class</th>
                            <th scope="col">ExerciseID</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="d-none" style="cursor: pointer;">
                            <td class="question-id">
                                1
                            </td>
                            <td class="question-name">Mark</td>
                            <td class="question-description">Otto</td>
                            <td class="question-platform">platform</td>
                            <td class="question-level">level</td>
                            <td class="question-class">@mdo</td>
                            <td class="question-exercise">@mdo</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex flex-row-reverse pr-2">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item exercise-previous"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item exercise-next"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
            <div class="d-flex justify-content-between p-2">
                <button type="button" class="btn btn-outline-primary question-submit">Submit</button>
                {{--                <button type="button" class="btn btn-outline-success">Add to List</button>--}}
            </div>
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        class QuestionExerciseMap {
            addedQuestions = [];
            searchedQuestions = [];
            questionTemplate = $("#table_id").find('tbody tr:first');
            searchedQuestionTemplate = $("#questionTable").find('tbody tr:first');

            constructor() {
                this.previous = false;
                this.page = 1;
                this.previous_link = false;
                this.next_link = false;
                this.totalPage = 1;
                this.id_search = null;
                this.name_search = null;
                this.class_search = null;
                this.platform_search = null;
                this.level_search = null;
                this.is_used_search = null;
                this.baseUrl = "{{$baseUrl}}";
                this.duplicateQuestionSelected = false;
                this.addedQuestions = [];
                this.searchedQuestions = [];
            }

            init() {
                jQuery.fn.questionExerciseMap = function () {
                    this.each(function (index, ele) {
                        jQuery(ele).click(() => {
                            questionExerciseMap.showModal(ele, true);
                        });
                    });
                };

                $(".questionExerciseMap").questionExerciseMap();
            }

            showModal() {
                $(".questionExerciseModal").modal('show');
            }

            paginate() {
                $('.exercise-previous').click(function () {
                    questionExerciseMap.questionData(false, true);
                })
                $('.exercise-next').click(function () {
                    questionExerciseMap.questionData(true, false);
                })
            }

            removeRow(next, previous) {
                if (next && questionExerciseMap.next_link) {
                    questionExerciseMap.page++;

                }

                if (previous && questionExerciseMap.previous_link) {
                    questionExerciseMap.page--
                }

                $('#questionTable tbody> tr').each(function (i, elem) {
                    if ($(elem).hasClass('add-row')) {
                        $(elem).remove();
                    }
                });
            }

            getSetLocalStorage(actions = 'get', key = 'QuestionPage', value = null) {
                if (actions === 'set') {
                    value = JSON.stringify(value);
                    return localStorage.setItem(key, value);
                }

                if (actions === 'get') {
                    value = localStorage.getItem(key);
                    return JSON.parse(value);
                }

                if (actions === 'del') {
                    localStorage.removeItem(key);
                }
            }

            renderSearchedQuestions() {
                if (questionExerciseMap.id_search || questionExerciseMap.name_search) {
                    questionExerciseMap.removeRow();
                }

                let table = $("#questionTable").find('tbody');
                table.html('');
                table.append(this.getSearchedQuestionTemplate());

                const _self = this;
                const questions = this.searchedQuestions;

                $(questions).each(function (index, elem) {
                    let added = false;
                    _self.addedQuestions.forEach((q, i) => {
                        if (q.id == elem.id) {
                            added = true;
                        }
                    });

                    if (added) {
                        return true;
                    }

                    let cloneable = _self.getSearchedQuestionTemplate();
                    $(cloneable).find('.question-id').html(elem.id);
                    $(cloneable).find('.question-name').html(elem.name);
                    $(cloneable).find('.question-description').html(elem.description);
                    $(cloneable).find('.question-class').html(elem.class_name);
                    $(cloneable).find('.question-platform').html(elem.template_name);
                    $(cloneable).find('.question-level').html(elem.level);
                    if (elem.exercise_ids) {
                        let exerciseID = elem.exercise_ids.join(',');
                        $(cloneable).find('.question-exercise').html(exerciseID);
                    }
                    $(cloneable).removeClass('d-none')
                    $(cloneable).addClass('add-row')

                    $(cloneable).click(() => {
                        questionExerciseMap.addQuestions([
                            {
                                'id': elem.id,
                                'name': elem.name
                            }
                        ]);
                    });

                    $(table).append(cloneable).trigger('change');
                });
            }

            getAddedQuestionTemplate() {
                return this.questionTemplate.clone();
            }

            getSearchedQuestionTemplate() {
                return this.searchedQuestionTemplate.clone();
            }

            renderAll() {
                this.renderAddedQuestions();
                this.renderSearchedQuestions();
            }

            renderAddedQuestions() {
                let table = $("#table_id").find('tbody');
                const template = this.getAddedQuestionTemplate();
                $(table).html('');
                $(table).append(template);
                const _self = this;

                this.addedQuestions.forEach(function (elem, i) {
                    const cloneable = _self.getAddedQuestionTemplate();
                    $(cloneable).find('.question-id').html(elem.id);
                    $(cloneable).find('.question-id').val(elem.id);
                    $(cloneable).find('.question-name').html(elem.name);

                    $(cloneable).removeClass('d-none');
                    $(cloneable).addClass('add-row');
                    $(cloneable).find('.removeRow').click(() => {
                        _self.removeQuestion(elem.id);
                    });
                    $(cloneable).find('.up').click(() => {
                        _self.moveUp(elem.id);
                    });
                    $(cloneable).find('.down').click(() => {
                        _self.moveDown(elem.id);
                    });
                    $(table).append(cloneable).trigger('change');
                });
            }

            moveUp(id) {
                let idx = null;

                this.addedQuestions.forEach((val, index) => {
                    if (val.id == id) {
                        idx = index;
                    }
                });

                if (idx == null || idx == 0 || !this.addedQuestions[idx]) {
                    return;
                }

                const temp = this.addedQuestions[idx];
                this.addedQuestions[idx] = this.addedQuestions[idx - 1];
                this.addedQuestions[idx - 1] = temp;

                this.renderAddedQuestions();
            }

            moveDown(id) {
                let idx = null;

                this.addedQuestions.forEach((val, index) => {
                    if (val.id == id) {
                        idx = index;
                    }
                });

                if (idx == null || idx == this.addedQuestions.length - 1 || !this.addedQuestions[idx]) {
                    return;
                }

                const temp = this.addedQuestions[idx + 1];
                this.addedQuestions[idx + 1] = this.addedQuestions[idx];
                this.addedQuestions[idx] = temp;

                this.renderAddedQuestions();
            }

            removeQuestion(id) {
                this.addedQuestions = this.addedQuestions.filter((value) => {
                    return value.id != id;
                });

                this.renderAll();
            }

            addQuestions(data = []) {
                const _self = this;
                $(data).each(function (i, elem) {
                    let questionExisted = false;
                    _self.addedQuestions.forEach(function (val, idx) {
                        if (val.id == elem.id) {
                            questionExisted = true;
                        }
                    });
                    if (questionExisted) {
                        return true;
                    }

                    _self.addedQuestions.push(elem);
                });

                this.renderAll();
            }

            setSearchedQuestions(questions) {
                this.searchedQuestions = questions;
                questionExerciseMap.renderSearchedQuestions();
            }

            questionData(next = false, previous = false) {
                questionExerciseMap.removeRow(next, previous)
                let url = questionExerciseMap.baseUrl + '/api/question?per_page=10&page=' + questionExerciseMap.page;

                if (questionExerciseMap.id_search) {
                    url += '&id=' + questionExerciseMap.id_search;

                }
                if (questionExerciseMap.name_search) {
                    url += '&name=' + questionExerciseMap.name_search;
                }

                if (questionExerciseMap.class_search) {
                    url += '&class_id=' + questionExerciseMap.class_search;
                }

                if (questionExerciseMap.platform_search) {
                    url += '&platform_id=' + questionExerciseMap.platform_search;
                }

                if (questionExerciseMap.level_search) {
                    url += '&level=' + questionExerciseMap.level_search;
                }

                if (questionExerciseMap.is_used_search) {
                    url += '&is_used=' + questionExerciseMap.is_used_search;
                }

                const _self = this;

                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    async: false,
                    headers: {
                        'Authorization': 'Bearer ' + API_TOKEN,
                    },
                    url: url,
                    success: function (data) {
                        let response = data.data;

                        if (response.pagination.previous_page_url) {
                            questionExerciseMap.previous_link = true;
                        } else {
                            questionExerciseMap.previous_link = false;
                        }

                        if (response.pagination.next_page_url) {
                            questionExerciseMap.next_link = true;
                        } else {
                            questionExerciseMap.next_link = false;
                        }
                        questionExerciseMap.totalPage = response.pagination.total_pages;
                        questionExerciseMap.page = response.pagination.current_page;
                        _self.setSearchedQuestions(response.questions);
                    },
                    error: function (er) {
                        console.log(er)
                    }
                });
            }

            searchTable() {
                questionExerciseMap.id_search = $("#question-id-search").val();
                questionExerciseMap.name_search = $("#question-name-search").val();
                questionExerciseMap.class_search = $("#question-class-search").val();
                questionExerciseMap.platform_search = $(".question-platformSelect-search").val();
                questionExerciseMap.level_search = $("#question-level-search").val();
                questionExerciseMap.is_used_search = $("#is_used_search").val();
                questionExerciseMap.questionData();
            }

            addToExercise() {
                let hasFailed = false;
                let data = [];
                $(".questionExercise").empty();
                $('#table_id tbody> tr').each(function (i, elem) {
                    if ($(elem).hasClass('add-row')) {
                        data.push({
                            'id': $(elem).find('.question-id').first().html(),
                            'name': $(elem).find('.question-name').first().html(),
                            'position': i
                        });
                    }
                });

                if (hasFailed) {
                    return;
                }

                questionExerciseMap.insertionSort(data);
                $('.questionExerciseModal').modal('hide')
            }

            checkIfDuplicateExists(arr) {
                return new Set(arr).size !== arr.length
            }

            insertionSort(data) {
                questionExerciseMap.sortQuestions(data);
            }

            sortQuestions(input) {

                let dataConvert = input.sort((a, b) => a.position - b.position);

                $(".questionExercise").empty();
                if (dataConvert) {
                    $(dataConvert).each(function (i, elem) {
                        let newState = new Option(elem.name, elem.id, true, true);
                        $('.questionExercise').append(newState).trigger('change');
                    })
                }
            }
        }

        const questionExerciseMap = new QuestionExerciseMap();
        window.addEventListener('DOMContentLoaded', () => {
            (function ($) {
                questionExerciseMap.questionData();
                questionExerciseMap.init()
                questionExerciseMap.paginate()
                questionExerciseMap.addQuestions()
                $(".question-search-form").on('click', function () {
                    questionExerciseMap.searchTable();
                })

                $('.question-submit').on('click', function () {
                    questionExerciseMap.addToExercise();
                })
                document.onkeydown = function (evt) {
                    if (evt.keyCode == 27) {
                        $('.questionExerciseModal').modal('hide')
                    }
                };

                let questions = $('#questionExerciseMap').attr('data-questions-selected');
                if (questions && questions.length) {
                    questions = JSON.parse(questions);
                    let dataConvert = questions.sort((a, b) => a.pivot.position - b.pivot.position);
                    questionExerciseMap.addQuestions(dataConvert);
                }
            })(jQuery);
        });
    </script>

@endpush
