<div class="table-responsive">
    <table class="table" id="questionPlatforms-table">
        <thead>
        <tr>
            <th>@lang('models/questionPlatforms.fields.id')</th>
            {{--            <th>@lang('models/questionPlatforms.fields.image')</th>--}}
            <th>@lang('models/questionPlatforms.fields.name')</th>
            <th>@lang('models/questionPlatforms.fields.code')</th>
            <th>@lang('models/questionPlatforms.fields.description')</th>
            <th>@lang('models/questionPlatforms.fields.is_active')</th>
            <th>@lang('models/questionPlatforms.fields.updated_at')</th>
            <th colspan="3">@lang('crud.action')</th>
        </tr>
        </thead>
        <tbody>
         @foreach($questionPlatforms as $questionPlatform)
            <tr>
                <td>{{$questionPlatform->id}}</td>
{{--                <td>--}}
{{--                    <img src="{{ $questionPlatform->image_url }}" width="50px" height="50px" style="object-fit: contain" alt="">--}}
{{--                </td>--}}
                <td>{{ $questionPlatform->name }}</td>
                <td>{{ $questionPlatform->code }}</td>
                <td>{{ $questionPlatform->description }}</td>
                <td><x-active-status :isActive="$questionPlatform->is_active" /></td>
                <td>{{ $questionPlatform->updated_at }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['questionPlatforms.destroy', $questionPlatform->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('questionPlatforms.edit', [$questionPlatform->id]) }}"
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
