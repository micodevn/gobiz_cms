@extends('layouts.app')
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

        <div class="card">
            <div class="card-header card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><b>SCHOOLS</b></h4>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('schools.create') }}"
                           class="btn btn-secondary btn-label waves-effect waves-light">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-plus label-icon align-middle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    Create
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="" class="dt-bootstrap4">
                    <div class="row">
                        @include('province::pages.schools.filter')
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-secondary">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Province</th>
                                    <th>District</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($data))
                                    @foreach($data as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>
                                                <a href="{{ route('schools.edit', ['school' => $value->id]) }}">{{ $value->name }}</a>

                                            </td>
                                            <td>
                                                {{ $value?->district?->province->name }}
                                            </td>
                                            <td>
                                                {{ $value?->district?->name }}
                                            </td>
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
                                                                <a href="{{ route('schools.edit',['school' => $value->id]) }}"
                                                                   class="dropdown-item">Sửa</a>
                                                            </li>
                                                            <li>
                                                                <form
                                                                    action="{{ route('schools.destroy',['school' => $value->id]) }}"
                                                                    method="POST">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button class="dropdown-item" type="submit"
                                                                            onclick="return confirm('Are you sure about that?')">
                                                                        Delete
                                                                    </button>
                                                                </form>
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
        </div>
        @endsection
        @push('page_scripts')
            <script>
                window.addEventListener('DOMContentLoaded', function () {
                    (function ($) {
                        $('.province_code').on('change', function (e) {
                            $.ajax({
                                url: '{!! route('provinces.load-districts') !!}',
                                data: {
                                    province_code: this.value,
                                    district_code: '{!! request()->get('district_code') !!}'
                                },
                                type: 'get',
                                success: function (response) {
                                    $(".district_code").html(response.data)
                                },
                                error: function (response) {
                                    console.log(response)
                                }
                            });
                        }).change()

                    })(jQuery)
                });
            </script>
    @endpush
