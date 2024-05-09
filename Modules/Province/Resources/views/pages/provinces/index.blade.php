@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1"><b>PROVINCES</b></h4>
            <div class="flex-shrink-0">
                <div class="form-check form-switch form-switch-right form-switch-md">
                    <a href="{{ route('provinces.create') }}"
                       class="btn btn-secondary btn-label waves-effect waves-light">
                        <div class="flex-grow-1">
                            Tạo mới
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="live-preview">
                @include('province::pages.provinces.filter')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-secondary">
                        <tr>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Type</th>
                            <th>Code</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($data))
                            @foreach($data as $key => $value)
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>
                                        <a href="{{ route('provinces.edit',['province' => $value->id]) }}">
                                            {{ $value->name }}
                                        </a>
                                    </td>
                                    <td>{{ $value->slug }}</td>
                                    <td>{{ $value->type }}</td>
                                    <td>{{ $value->code }}</td>
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
                                                        <a href="{{ route('provinces.edit',['province' => $value->id]) }}"
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
