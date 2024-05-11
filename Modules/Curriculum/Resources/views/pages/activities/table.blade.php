<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="activities-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Mô tả</th>
                <th>Position</th>
                <th>Part</th>
                <th>Kích hoạt</th>
{{--                <th>Buổi học</th>--}}
{{--                <th>Loại part</th>--}}
                <th colspan="3">Thao tác</th>
            </tr>
            </thead>
            <tbody>
            @foreach($activities as $activity)
                <tr>
                    <td>{{ $activity->id }}</td>
                    <td>{{ $activity->name }}</td>
                    <td>{{ $activity->description }}</td>
                    <td>{{ $activity->position }}</td>
                    <td>{{ \Modules\Curriculum\Entities\Part::find($activity->part_id)->name }}</td>
                    <td>{!! $activity->is_active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>' !!}</td>
{{--                    <td>{{ $activity->lesson ? $activity->lesson->title : '' }}</td>--}}
{{--                    <td>{{ $activity->type ? \Modules\Curriculum\Entities\Part::PART_TYPES[$activity->type] : '' }}</td>--}}
                    <td style="width: 120px">
                        {!! Form::open(['route' => ['activities.destroy', $activity->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            {{--                            <a href="{{ route('activities.show', [$activity->id]) }}"--}}
                            {{--                               class='btn btn-primary'>--}}
                            {{--                                <i class="fas fa-edit"></i>--}}
                            {{--                            </a>--}}
                            <a href="{{ route('activities.edit', [$activity->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $activities])
        </div>
    </div>
</div>
