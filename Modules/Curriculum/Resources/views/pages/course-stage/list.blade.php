@extends('layouts.main')
@section('title')
    List Time Table
@endsection
@section('css')
@endsection
@section('page-content')
    <div class="card">
        <div class="card-header card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">THỜI KHÓA BIỂU</h4>
            <div class="flex-shrink-0">
                <div class="form-check form-switch form-switch-right form-switch-md">
{{--                    @if(can('ctv-module-class') || \Illuminate\Support\Facades\Auth::user()->hasRole([\Modules\Syllabus\Helpers\PermissionClassroom::ROLE_B2B_ADMIN,\Modules\Syllabus\Helpers\PermissionClassroom::ROLE_GIAOVU_ADMIN, 'CTV_TUTOR']))--}}
                        <a href="{{ route('timetable.create') }}"
                           class="btn btn-secondary btn-label waves-effect waves-light">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-plus label-icon align-middle"></i>
                                </div>
                                <div class="text-uppercase">
                                    THÊM MỚI
                                </div>
                            </div>
                        </a>
{{--                    @endif--}}
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="live-preview">
                @include('curriculum::pages.timetable.filter')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-secondary">
                        <tr>
                        <tr>
                            <th>ID</th>
                            <th>Tên TKB</th>
                            <th>Lộ trình</th>
                            <th>Kiểu</th>
                            <th>Phân loại</th>
                            <th>Năm học</th>
                            <th>Khối lớp</th>
                            <th>Stage</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $k => $value)
                            <tr>
                                <td>{{$value->id}}</td>
                                <td>
                                    <a href="{{route('timetable.edit',$value->id)}}">
                                        {{$value->name}}
                                    </a>
                                </td>
                                <td>{{@$value->getSyllabus->name}}</td>
                                @php
                                    $classPattern = 'warning';
                                    if ($value->pattern == 'FIXED') $classPattern = 'info';
                                @endphp
                                <td>
                                    <button class="btn btn-sm btn-{{ $classPattern }}">{{ @$value->pattern  }}</button>
                                </td>
                                <td>{{@$value->type}}</td>
                                <td><b>Start</b>: {{$value->start_time}} <br>
                                    <b>End</b> : {{$value->end_time}}
                                </td>
                                @php
                                    $classGrade = 'warning';
                                    if ($value->grade_id == 4) $classGrade = 'info';
                                    if ($value->grade_id == 5) $classGrade = 'success';
                                @endphp
                                <td>
                                    <button class="btn btn-sm btn-{{ $classGrade }}">Lớp {{ @$value->grade_id  }}</button>
                                </td>
                                <td>{{count($value->getStage)}}</td>
                                <td><b>Created At</b>: {{$value->created_at}} <br>
                                    <b>Updated At</b>: {{$value->updated_at}} </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{route('timetable.edit', $value->id)}}">Xem chi tiết</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
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
            @include('pages.toast')
        </div>
    </div>
@endsection
