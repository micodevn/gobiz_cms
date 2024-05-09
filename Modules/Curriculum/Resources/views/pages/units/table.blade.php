<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="courses-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Tên Unit</th>
                <th class="w-25">Mô tả</th>
                <th>Code</th>
                <th>Level</th>
                <th>Thumbnail</th>
                <th>Kích hoạt</th>
                <th colspan="3">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($units as $unit)
                <tr>
                    <td>{{ $unit->id }}</td>
                    <td>{{ $unit->name }}</td>
                    <td><p>{{ $unit->description }}</p></td>
                    <td>{{ $unit->code }}</td>
                    <td>{{ \Modules\Curriculum\Entities\Level::find($unit->level_id)->title }}</td>
                    <td><img src="{{$unit->thumbnail}}" alt="" width="150px"></td>
                    <td>{!! $unit->is_active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>' !!}</td>
                    <td style="width: 120px">
                        {!! Form::open(['route' => ['units.destroy', $unit->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('units.edit', [$unit->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $units])
        </div>
    </div>
</div>
