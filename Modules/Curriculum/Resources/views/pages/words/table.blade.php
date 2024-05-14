<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="courses-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Text</th>
                <th class="w-25">Description</th>
                <th>Active</th>
                <th colspan="3">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($words as $word)
                <tr>
                    <td>{{ $word->id }}</td>
                    <td>{{ $word->text }}</td>
                    <td><p>{{ $word->description }}</p></td>
                    <td>{!! $word->is_active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>' !!}</td>
                    <td style="width: 120px">
                        {!! Form::open(['route' => ['words.destroy', $word->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('words.edit', [$word->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $words])
        </div>
    </div>
</div>
