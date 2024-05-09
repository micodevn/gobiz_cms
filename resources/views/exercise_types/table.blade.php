<div class="table-responsive">
    <table class="table" id="exerciseTypes-table">
        <thead>
        <tr>
            <th>@lang('models/exerciseTypes.fields.id')</th>
        <th>@lang('models/exerciseTypes.fields.name')</th>
        <th>@lang('models/exerciseTypes.fields.code')</th>
        <th>@lang('models/exerciseTypes.fields.description')</th>
            <th colspan="3">@lang('crud.action')</th>
        </tr>
        </thead>
        <tbody>
         @foreach($exerciseTypes as $exerciseType)
            <tr>
                <td>{{ $exerciseType->id }}</td>
            <td>{{ $exerciseType->name }}</td>
            <td>{{ $exerciseType->code }}</td>
            <td>{{ $exerciseType->description }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['exercise-types.destroy', $exerciseType->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('exercise-types.show', [$exerciseType->id]) }}"
                           class='btn btn-primary'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('exercise-types.edit', [$exerciseType->id]) }}"
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
