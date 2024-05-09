@extends('layouts.app')
@section('title')
    Quản lý bài thi
@endsection
@section('content')
    <section class="content-header">
        @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('success') }}
            </div>
        @elseif (session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session()->get('error') }}
            </div>
        @endif
    </section>

    <div class="card">
        <div class="card-header card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1"><b>contests</b></h4>
            <div class="flex-shrink-0">
                <div class="form-check form-switch form-switch-right form-switch-md">
                    <a href="{{ route('contests.create') }}"
                       class="btn btn-secondary btn-label waves-effect waves-light">
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
        <div class="card-body">
            <div class="live-preview">
                @include('contest::pages.contests.filter')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-secondary">
                        <tr>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Số vòng thi đang có</th>
                            <th>Khối lớp</th>
                            <th>Loại</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($listContest))
                            @foreach($listContest as $key => $value)
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>
                                        <a href="{{ route('contests.edit',['contest' => $value->id]) }}">
                                            {{ $value->title }}
                                        </a>
                                    </td>
                                    <td>{{ count($value->rounds) }}</td>
                                    <td>{{ !empty($value->grade) ? $value->grade->title : 'Chưa có'}}</td>
                                    <td>{{ \Modules\Contest\Entities\Contest::TYPE[$value->type]}}</td>
                                    <td>{!! $value->is_active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>' !!}</td>
                                    <td>
                                        <div class="btn-group" role="group"
                                             aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop1" type="button"
                                                        class="btn btn-info dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    <li>
                                                        <a href="{{ route('contests.edit',['contest' => $value->id]) }}"
                                                           class="dropdown-item">Sửa</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row m-auto div-paginate">
                <div class="col-12 text-center">
                    @if(isset($data) && count($data))
                        {{ $data->appends(request()->input())->links() }}
                    @endif
                </div>
            </div>
            @include('components.toast')
        </div>
    </div>
@endsection
