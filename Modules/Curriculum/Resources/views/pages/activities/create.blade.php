@extends('layouts.app')

@section('content')
    <div class="content">

        @include('adminlte-templates::common.errors')

        <div class="card">
            <div class="card-header card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><b>Thêm mới</b></h4>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('activities.index') }}" class="btn btn-primary"> <i
                                class="fas fa-list pr-2"></i>
                            Danh sách</a>
                    </div>
                </div>
            </div>
            {!! Form::open(['route' => 'activities.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('curriculum::pages.activities.fields', ['activity' => new \Modules\Curriculum\Entities\Activity()])
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('activities.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
@push('page_scripts')
    <script src="/storage/js/init-selected-api.js?v={{config('cdn.version_script')}}" defer></script>
    <script>
        $(document).ready(function (){
            // IMAGE APP
            $('.select2-image-app').select2({
                theme: 'bootstrap4',
                ajax: {
                    url: "{!! route('api.file.search') !!}",
                    dataType: 'json',
                    method : 'GET',
                    data: function (params) {
                        return {
                            search : params.term,
                            filters: {
                                type: 'IMAGE'
                            }
                        };
                    },
                    processResults: function (data, params) {
                        return {
                            results: data.data.files,
                        };
                    },
                },
                placeholder: 'Type ID or Name to search !',
                templateResult: formatRepoImageApp,
                templateSelection: formatRepoImageAppSelection
            })

        })
        function formatRepo(repo) {
            if (repo.loading) {
                return repo.text;
            }
            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__avatar'></div>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'></div>" +
                "<div class='select2-result-repository__description'></div>" +
                "<div class='select2-result-repository__statistics'>" +
                "</div>" +
                "</div>" +
                "</div>"
            );
            $container.find(".select2-result-repository__title").text(repo.id + ' | ' + repo.name);

            return $container;
        }
        function formatRepoSelection(repo) {
            let title = repo.name || repo.title
            return repo.id + ' | ' + title
        }
        function formatRepoImage(repo) {
            if (repo.loading) {
                return repo.text;
            }
            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__avatar'></div>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'></div>" +
                "<div class='select2-result-repository__description'></div>" +
                "<div class='select2-result-repository__statistics'>" +
                "</div>" +
                "</div>" +
                "</div>"
            );
            $container.find(".select2-result-repository__title").text(repo.id + ' | ' + repo.name ? repo.name : repo.title);

            return $container;
        }
        function formatRepoImageSelection(repo) {
            if(repo.id == 0){
                return 'Search Image here ...';
            }else {
                $(".img-preview").html(`<img style="width: 150px;height: 150px;object-fit: cover" src="${repo.file_path_url}" alt="">`)
                $("#image").val(repo.file_path_url)
                return repo.id + ' | ' + repo.name
            }
        }

        function formatRepoImageApp(repo) {
            if (repo.loading) {
                return repo.text;
            }
            let $container = $(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__avatar'></div>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'></div>" +
                "<div class='select2-result-repository__description'></div>" +
                "<div class='select2-result-repository__statistics'>" +
                "</div>" +
                "</div>" +
                "</div>"
            );

            $container.find(".select2-result-repository__title").text(repo.id + ' | ' + repo.name);

            return $container;
        }
        function formatRepoImageAppSelection(repo) {
            if(repo.id == 0){
                return 'Search Image here ...';
            }else {
                $(".img-app-preview").html(`<img style="width: 150px;height: 150px;object-fit: cover" src="${repo.file_path_url}" alt="">`)
                $("#app_image").val(repo.file_path_url)
                return repo.id + ' | ' + repo.name
            }
        }
        function changeImage(obj) {
            let parentDiv = $(obj).parent().find('div.img-preview');
            let itemPath = $(obj).find(":selected").attr('data-path');
            if (itemPath === '') {
                parentDiv.find('img').remove();
            } else {
                parentDiv.html(`<img style="width: 150px;height: 150px;object-fit: cover" src="${itemPath}" alt="">`)
            }
        }
    </script>
@endpush
