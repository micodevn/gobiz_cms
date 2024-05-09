<div class="table-responsive">
    <table class="table" id="goals-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Active</th>
            <th colspan="3">@lang('crud.action')</th>
        </tr>
        </thead>
        <tbody>
         @foreach($goals as $goal)
            <tr>
                <td>{{$goal->id}}</td>
                <td>{{ $goal->name }}</td>
                <td><x-active-status :isActive="$goal->is_active" /></td>
                <td width="120">
                    {!! Form::open(['route' => ['goals.destroy', $goal->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('goals.show', [$goal->id]) }}"
                           class='btn btn-primary'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('goals.edit', [$goal->id]) }}"
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
