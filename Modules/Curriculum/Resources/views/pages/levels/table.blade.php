<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="courses-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Tên level</th>
                <th class="w-25">Mô tả</th>
                <th>Code</th>
                <th>Position</th>
                <th>Thumbnail</th>
                <th>Kích hoạt</th>
                <th colspan="3">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($levels as $level)
                <tr>
                    <td>{{ $level->id }}</td>
                    <td>{{ $level->title }}</td>
                    <td><p>{{ $level->description }}</p></td>
                    <td>{{ $level->code }}</td>
                    <td>{{ $level->position }}</td>
                    <td><img src="{{$level->thumbnail}}" alt="" width="150px"></td>
                    <td>{!! $level->is_active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>' !!}</td>
                    <td style="width: 120px">
                        {!! Form::open(['route' => ['levels.destroy', $level->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            {{--                            <a href="{{ route('courses.show', [$course->id]) }}"--}}
                            {{--                               class='btn btn-primary'>--}}
                            {{--                                <i class="fas fa-edit"></i>--}}
                            {{--                            </a>--}}
                            <a href="{{ route('levels.edit', [$level->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $levels])
        </div>
    </div>
</div>
