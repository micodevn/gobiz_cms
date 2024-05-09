<div class="table-responsive">
    <table class="table" id="topics-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Status</th>
            <th colspan="3">@lang('crud.action')</th>
        </tr>
        </thead>
        <tbody>
         @foreach($topics as $topic)
            <tr>
                <td>{{ $topic->id }}</td>
                <td>{{ $topic->name }}</td>
                <td>{{ $topic->slug }}</td>
                <td><x-active-status :isActive="$topic->is_active" /></td>
                <td width="120">
                    {!! Form::open(['route' => ['topics.destroy', $topic->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('topics.edit', [$topic->id]) }}"
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
