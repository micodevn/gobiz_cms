@extends('layouts.app')

@section('content')
    <div class="content">
        @include('flash::message')
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-header card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><b>Config</b></h4>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('configs.create') }}" class="btn btn-primary"> <i
                                class="fas fa-list pr-2"></i>
                            Thêm mới</a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table" id="grades-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Key</th>
                            <th>Code</th>
                            <th>Kích hoạt</th>
                            <th colspan="3">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($listConfig as $config)
                            <tr>
                                <td>{{ $config->id }}</td>
                                <td>{{ $config->key }}</td>
                                <td>{{ $config->code }}</td>
                                <td>{!! $config->is_active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>' !!}</td>
                                <td  style="width: 120px">
                                    {!! Form::open(['route' => ['configs.destroy', $config->id], 'method' => 'delete']) !!}
                                    <div class='btn-group'>
                                        <a href="{{ route('configs.edit', [$config->id]) }}"
                                           class='btn btn-primary'>
                                            <i class="far fa-edit"></i>
                                        </a>
                                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', ['records' => $listConfig])
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
