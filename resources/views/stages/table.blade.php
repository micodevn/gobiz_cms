<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="stages-table">
            <thead>
            <tr>
                <th>Tiêu đề</th>
                <th>Mô tả</th>
                <th>Khoá học</th>
                <th>Kích hoạt</th>
                <th colspan="3">Thao tác</th>
            </tr>
            </thead>
            <tbody>
            @foreach($stages as $stage)
                <tr>
                    <td>{{ $stage->title }}</td>
                    <td>{{ $stage->description }}</td>
                    <td>{{ $stage->course->title }}</td>
                    <td>{!! $stage->is_active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>' !!}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['stages.destroy', $stage->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
{{--                            <a href="{{ route('stages.show', [$stage->id]) }}"--}}
{{--                               class='btn btn-primary'>--}}
{{--                                <i class="fas fa-edit"></i>--}}
{{--                            </a>--}}
                            <a href="{{ route('stages.edit', [$stage->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $stages])
        </div>
    </div>
</div>
