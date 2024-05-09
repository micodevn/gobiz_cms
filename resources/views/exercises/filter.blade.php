<div class="row mb-2 justify-content-between mx-3">
    <div class="card w-100 card-default">
        <div class="card-body">
            <div class="row">
                <form action="" method="get" class="w-100">
                    @csrf
                    <div class="col-12 row">
                        <div class="form-group mb-0 col-1">
                            <div class="form-group">
                                <input value="{{request()->get('id')}}" placeholder="ID" name="id" type="number" min="0"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-0 col-2">
                            <div class="form-group">
                                <input value="{{ request()->get('name', old('name')) }}" placeholder="Name" name="name"
                                       type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-0 col-2">
                            <div class="form-group">
                                <select name="platform" class="form-control select2bs4" style="width: 100%;">
                                    <option
                                        {{request()->get('platform') == '' || request()->get('platform') == null ? 'selected' : ''}} value="">
                                        Choose Platform
                                    </option>
                                    @foreach($platforms as $k=>$v)
                                        <option
                                            {{request()->get('platform') ==  $v->id  ? 'selected' : ''}} value="{{ $v->id }}">{{ $v->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-0 col-2">
                            <div class="form-group">
                                <?php
                                $topicSelected = request()->get('topic_id') ?? [];
                                $topicSelected = is_array($topicSelected) ? $topicSelected : (array)$topicSelected;
                                ?>
                                <select name="topic_id[]" id="topic_id" class="no-init" multiple>
                                    @foreach($listTopics as $key => $listTopic)
                                        <option
                                            {{ in_array($key,$topicSelected) ? "selected" : '' }} value="{{$key}}">{{$listTopic}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-0 col-2">
                            <div class="form-group">
                                <x-api-select
                                    :attributes="['multiple' => 'multiple']"
                                    :url="route('exerciseType.list')"
                                    emptyValue=""
                                    name="exercise_types[]"
                                    placeholder="Search exercise type"
                                    class="type-select"
                                ></x-api-select>
                            </div>
                        </div>

                        <div class="form-group mb-0 col-1">
                            <div class="form-group">
                                <select class="form-control select2bs4" name="status" style="width: 100%;">
                                    <option value="" selected="selected">Status</option>
                                    <option {{request()->get('status') === '1' ? 'selected' : ''}} value="1">Active
                                    </option>
                                    <option {{request()->get('status') === '0' ? 'selected' : ''}} value="0">DeActive
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-0 col-1">
                            <button type="submit" class="btn btn-secondary"><i class="mdi mdi-magnify search-widget-icon"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@push('page_scripts')
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            (function ($) {
                let typeExSearching = sessionStorage.getItem('ExPlatformSearching');
                sessionStorage.removeItem('ExPlatformSearching')
                $('.platformSelect').val('');
                if (typeExSearching) {
                    let typExSelect = JSON.parse(typeExSearching);
                    $(typExSelect).each(function (i, elem) {
                        let newState = new Option(elem.name, elem.id, true, true);
                        $('.type-select').append(newState).trigger('change');
                    })
                }

                $("#topic_id").select2({
                    multiple: true,
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: "Search for Topic",
                    allowClear: true,
                });
                $("#level").select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: "Search for Level",
                    allowClear: true,
                })

                $("#exercise-search-form").on('click', function (e) {
                    let conceptName = $('.type-select').find(":selected");
                    console.log({conceptName})
                    let ExTypeSearchInfo = [];
                    conceptName.each(function (i, elem) {
                        ExTypeSearchInfo.push({'id': $(elem).val(), 'name': elem.text});
                    })

                    ExTypeSearchInfo && sessionStorage.setItem('ExPlatformSearching', JSON.stringify(ExTypeSearchInfo));
                });
            })(jQuery);
        })
    </script>
@endpush
