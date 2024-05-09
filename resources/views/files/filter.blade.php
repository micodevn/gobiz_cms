<?php
//dd(request()->get('labels'));
?>
<div class="row mb-2 justify-content-between mx-3">
    <div class="card w-100 card-default">

        <div class="card-body">
            <div class="row">
                <form action="" method="get" class="w-100">
                    @csrf
                    <div class="col-12 row">
                        <div class="form-group mb-0 col-1">
                            <div class="form-group">
                                <input value="{{ request()->get('id') }}" placeholder="ID" name="id" min="1"
                                       type="number" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-0 col-2">
                            <div class="form-group">
                                <input value="{{ request()->get('name') }}" placeholder="Name" name="name" type="text"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-0 col-2">
                            <div class="form-group">
                                <select name="type" class="form-control select2bs4" style="width: 100%;">
                                    <option
                                        {{request()->get('type') == '' || request()->get('type') == null ? 'selected' : ''}} value="">
                                        Choose Type
                                    </option>
                                    @foreach($types as $v)
                                        <option
                                            {{request()->get('type') ==  $v  ? 'selected' : ''}} value="{{ $v }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-0 col-2">
                            <div class="form-group">
                                <x-api-select
                                    :attributes="['multiple' => 'multiple']"
                                    :url="route('list-labels')"
                                    emptyValue=""
                                    name="labels[]"
                                    placeholder="Search Labels"
                                    class="abcde label-type-select"
                                ></x-api-select>
                            </div>
                        </div>
                        <div class="form-group mb-0 col-2">
                            <div class="form-group">
                                <select class="form-control select2bs4" name="is_active" style="width: 100%;">
                                    <option value="" selected="selected">Status</option>
                                    <option {{request()->get('status') === '1' ? 'selected' : ''}} value="1">Active
                                    </option>
                                    <option {{request()->get('status') === '0' ? 'selected' : ''}} value="0">DeActive
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-0 col-1">
                            <button type="submit" class="btn color-edupia" id="file-search-form"><i
                                    class="fas fa-search"></i>
                                {{--                                <span class="search-filter-text">Search</span> --}}
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
                let fileLabelSearching = sessionStorage.getItem('FileLabelSearching');
                sessionStorage.removeItem('FileLabelSearching')
                $('.label-type-select').val('');
                if (fileLabelSearching) {
                    let typExSelect = JSON.parse(fileLabelSearching);
                    $(typExSelect).each(function (i, elem) {
                        let newState = new Option(elem.name, elem.id, true, true);
                        $('.label-type-select').append(newState).trigger('change');
                    })
                }

                $("#file-search-form").on('click', function (e) {
                    let conceptName = $('.label-type-select').find(":selected");
                    let ExTypeSearchInfo = [];
                    conceptName.each(function (i, elem) {
                        ExTypeSearchInfo.push({'id': $(elem).val(), 'name': elem.text});
                    })

                    ExTypeSearchInfo && sessionStorage.setItem('FileLabelSearching', JSON.stringify(ExTypeSearchInfo));
                });
            })(jQuery);
        });
    </script>
@endpush
