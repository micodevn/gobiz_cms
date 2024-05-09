<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="lessons-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Mô tả</th>
                <th>Loại buổi học</th>
{{--                <th>Tuần học</th>--}}
                <th>Kích hoạt</th>
                <th colspan="3">Thao tác</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lessons as $lesson)
                <tr>
                    <td>{{ $lesson->id }}</td>
                    <td>{{ $lesson->title }}</td>
                    <td>{{ $lesson->description }}</td>
                    <td>{{ $lesson->type ? Modules\Curriculum\Entities\Lesson::LESSON_TYPES[$lesson->type] :'' }}</td>
{{--                    <td>{{ $lesson->stage_id ?  $stages[$lesson->stage_id] : '' }}</td>--}}
                    <td>{!! $lesson->is_active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>' !!}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['lessons.destroy', $lesson->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
{{--                            <a href="{{ route('lessons.show', [$lesson->id]) }}"--}}
{{--                               class='btn btn-primary'>--}}
{{--                                <i class="fas fa-edit"></i>--}}
{{--                            </a>--}}
                            <a href="{{ route('lessons.edit', [$lesson->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $lessons])
        </div>
    </div>
</div>
