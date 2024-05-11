<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="parts-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Mô tả</th>
                <th>Position</th>
                <th>Unit</th>
                <th>Kích hoạt</th>
{{--                <th>Buổi học</th>--}}
{{--                <th>Loại part</th>--}}
                <th colspan="3">Thao tác</th>
            </tr>
            </thead>
            <tbody>
            @foreach($parts as $part)
                <tr>
                    <td>{{ $part->id }}</td>
                    <td>{{ $part->name }}</td>
                    <td>{{ $part->description }}</td>
                    <td>{{ $part->position }}</td>
                    <td>{{ \Modules\Curriculum\Entities\Unit::find($part->unit_id)->name }}</td>
                    <td>{!! $part->is_active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>' !!}</td>
{{--                    <td>{{ $part->lesson ? $part->lesson->title : '' }}</td>--}}
{{--                    <td>{{ $part->type ? \Modules\Curriculum\Entities\Part::PART_TYPES[$part->type] : '' }}</td>--}}
                    <td style="width: 120px">
                        {!! Form::open(['route' => ['parts.destroy', $part->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            {{--                            <a href="{{ route('parts.show', [$part->id]) }}"--}}
                            {{--                               class='btn btn-primary'>--}}
                            {{--                                <i class="fas fa-edit"></i>--}}
                            {{--                            </a>--}}
                            <a href="{{ route('parts.edit', [$part->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $parts])
        </div>
    </div>
</div>
