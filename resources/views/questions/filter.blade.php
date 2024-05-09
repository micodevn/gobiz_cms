<?php //dd($questions) ?>
<div class="row mb-2 justify-content-between mx-3">
    <div class="card w-100 card-default">

        <div class="card-body">
            <div class="row">
                <form action="" method="get" class="w-100">
                    @csrf
                    <div class="col-12 row">
                        <div class="form-group mb-2 col-1">
                            <div class="form-group">
                                <input value="{{request()->get('id')}}" placeholder="ID" name="id" type="number" min="0"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-2 col-2">
                            <div class="form-group">
                                <input value="{{request()->get('name')}}" placeholder="Name" name="name" type="text"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-2 col-2">
                            <div class="form-group">
                                <x-api-select
                                        :attributes="['multiple' => 'multiple']"
                                        :url="route('question-platform.group-options')"
                                        emptyValue=""
                                        name="platforms[]"
                                        placeholder="Search Platform"
                                        class="platformSelect"
                                ></x-api-select>
                            </div>
                        </div>
                        <div class="form-group col-3">
                            <div class="form-group">
                                <?php
                                $topicSelected = request()->get('topic_id') ?? null;
                                ?>
                                <select name="topic_id" id="question_topics" class="no-init" data-placeholder="Topic">
                                    <option></option>
                                    @foreach($listTopics as $key => $listTopic)
                                        <option {{ $key == $topicSelected ? "selected" : '' }} value="{{$key}}">{{$listTopic}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-2 col-2">
                            <div class="form-group">
                                <select name="level" id="level" data-placeholder="Độ khó">
                                    <option></option>
                                    @foreach(\App\Models\Question::LEVEL_QUESTIONS as $key => $val)
                                        <option {{request()->get('level') == $key ? "selected='selected'" : '' }} value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-2 col-2">
                            <div class="form-group">
                                <select class="form-control select2bs4" name="is_active" style="width: 100%;"
                                        data-placeholder="Trạng thái">
                                    <option value="" selected="selected">Status</option>
                                    <option {{request()->get('status') === '1' ? 'selected' : ''}} value="1">Active
                                    </option>
                                    <option {{request()->get('status') === '0' ? 'selected' : ''}} value="0">DeActive
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-2 col-1">
                            <button type="submit" id="question-search-form" class="btn btn-secondary"><i
                                        class="mdi mdi-magnify search-widget-icon"></i>
                                {{--                                <span class="search-filter-text">Search</span>--}}
                            </button>
                        </div>
                    </div>
                </form>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
    <!-- /.card -->
</div>

@push('page_scripts')
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            (function ($) {
                let platformSearching = sessionStorage.getItem('platformSearching');
                sessionStorage.removeItem('platformSearching')
                $('.platformSelect').val('');
                if (platformSearching) {
                    let platformSelect = JSON.parse(platformSearching);
                    $(platformSelect).each(function (i, elem) {
                        let newState = new Option(elem.name, elem.id, true, true);
                        $('.platformSelect').append(newState).trigger('change');
                    })
                }
                $("#question_topics").select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: "Select Topic",
                    allowClear: true,
                });
                $("#level").select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: "Select Level",
                    allowClear: true,
                })
                $("#level").select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: "Select Level",
                    allowClear: true,
                })

                $("#question-search-form").on('click', function (e) {
                    let conceptName = $('.platformSelect').find(":selected");
                    let platformSearchInfo = [];
                    conceptName.each(function (i, elem) {

                        platformSearchInfo.push({'id': $(elem).val(), 'name': elem.text});
                    })
                    platformSearchInfo && sessionStorage.setItem('platformSearching', JSON.stringify(platformSearchInfo));
                });

            })(jQuery);
        })
    </script>
@endpush

