<div class="table-responsive">
    @include('questions.filter')
    <table class="table" id="questions-table">
        <thead>
        <tr>
            <th>@lang('models/questions.fields.id')</th>
            <th>@lang('models/questions.fields.name')</th>
            <th>@lang('models/questions.fields.platform')</th>
            <th>@lang('models/questions.fields.topic_id')</th>
            <th>@lang('models/questions.fields.level')</th>
            <th>@lang('models/questions.fields.is_active')</th>
            <th>@lang('models/questions.fields.created_at')</th>
            <th colspan="3">@lang('crud.action')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($questions as $question)
            <tr>
                <td>{{ $question->id }}</td>
                <td>{{ $question->name }}</td>
                <td>{{ $question->platform_name }}</td>
                <td>{{ $question->topic_id  }}</td>
                <td>{{ $question->level  }}</td>
                <td><x-active-status :isActive="$question->is_active" /></td>
                <td>{{$question->created_at}}</td>
                <td width="120">
                    {!! Form::open(['route' => ['questions.destroy', $question->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('questions.edit', [$question->id]) }}"
                           class='btn btn-primary'>
                            <i class="far fa-edit"></i>
                        </a>
                        <a href="{{ route('questions.replicate', ['id'=>$question->id]) }}"
                           class='btn btn-info'>
                            <i class="far fa-copy"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="row m-auto div-paginate">
        <div class="col-12 text-center">
            @if(isset($questions) && count($questions))
                {{ $questions->appends(request()->input())->links() }}
            @endif
        </div>
    </div>
</div>
