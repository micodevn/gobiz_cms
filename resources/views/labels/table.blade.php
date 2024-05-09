<div class="table-responsive">
    <table class="table" id="labels-table">
        <thead>
        <tr>
            <th>@lang('models/labels.fields.id')</th>
            <th>@lang('models/labels.fields.name')</th>
            <th>@lang('models/labels.fields.attribute')</th>
            <th>@lang('models/labels.fields.status')</th>
            <th colspan="3">@lang('crud.action')</th>
        </tr>
        </thead>
        <tbody>
         @foreach($labels as $label)
            <tr>
                <td>{{ $label->id }}</td>
                <td>{{ $label->name }}</td>
                <td>{{ $label->attribute }}</td>
                <td><x-active-status :isActive="$label->status" /></td>
                <td width="120">
                    {!! Form::open(['route' => ['labels.destroy', $label->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('labels.edit', [$label->id]) }}"
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
