@extends('layouts.app')
<style>
    .chart {
        padding: 30px;
        margin: 5px auto;
        height: 600px;
        width: 100%
    }

    .node {
        border: 2px solid #C8C8C8;
        border-radius: 3px;
        display: flex;
        align-items: center;
    }

    .node p {
        color: black;
    }

    .node p, .node a {
        font-size: 15px;
        font-weight: 500;
        padding: 3px;
        margin: 0;
    }
</style>
@section('content')
    @include('question_platforms.filter')
    <div class="content">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-header card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><b>Question Platform</b></h4>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('questionPlatforms.create') }}" class="btn btn-primary"> <i
                                class="fas fa-list pr-2"></i>
                            Thêm mới</a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                @include('question_platforms.table')

                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', ['records' => $questionPlatforms])
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    <div class="modal fade" id="platform-chart-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"--}}
{{--         aria-hidden="true">--}}
{{--        <div class="modal-dialog modal-xl" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title" id="exampleModalLabel">Platform Chart</h5>--}}
{{--                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <div class="chart Treant loaded" id="platform-charts"></div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
@push('page_scripts')
{{--    <script src="/assets/libs/treant/utils/raphael.js"></script>--}}
{{--    <script src="/assets/libs/treant/Treant.js"></script>--}}
    <script>

        {{--window.addEventListener('DOMContentLoaded', function () {--}}
        {{--    (function ($) {--}}
        {{--        $("#platform-chart-modal").on('shown.bs.modal', function () {--}}
        {{--            try {--}}
        {{--                const platforms = '@json($platformTree)';--}}
        {{--                // console.log(JSON.parse(platforms));--}}
        {{--                var simple_chart_config = {--}}
        {{--                    chart: {--}}
        {{--                        container: "#platform-charts",--}}
        {{--                        rootOrientation: "WEST",--}}
        {{--                        connectors: {--}}
        {{--                            type: 'step'--}}
        {{--                        },--}}
        {{--                        nodeAlign: 'BOTTOM'--}}
        {{--                    },--}}
        {{--                    nodeStructure: JSON.parse(platforms)--}}
        {{--                };--}}
        {{--                new Treant(simple_chart_config, function () {--}}
        {{--                    // const $oNodes = $('.Treant .node');--}}
        {{--                    // $oNodes.on('click', function (oEvent) {--}}
        {{--                    //         const $oNode = $(this).data('treenode');--}}
        {{--                    //         window.location.href = '/questionPlatforms/' + $oNode.id + '/edit';--}}
        {{--                    //     }--}}
        {{--                    // );--}}
        {{--                }, jQuery);--}}
        {{--            } catch (e) {--}}
        {{--                console.log(e)--}}
        {{--            }--}}
        {{--        });--}}
        {{--    })(jQuery);--}}
        {{--});--}}
    </script>
@endpush


