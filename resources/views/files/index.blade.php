@extends('layouts.app')

@section('content')
    @include("files.filter")
    <div class="content">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-header card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Files</h4>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('files.create') }}" class="btn btn-secondary btn-label waves-effect waves-light">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-plus label-icon align-middle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    Tạo mới
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                @include('files.table')

                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', ['records' => $files])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
    <script src="/storage/js/init-selected-api.js?v={{config('cdn.version_script')}}"></script>
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


