<div class="table-responsive">
    <table class="table" id="targetLanguages-table">
        <thead>
        <tr>
            <th>@lang('models/targetLanguages.fields.id')</th>
            <th>@lang('models/targetLanguages.fields.target_language')</th>
            <th>@lang('models/targetLanguages.fields.part')</th>
            <th>Explain</th>
            <th colspan="3">@lang('crud.action')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($targetLanguages as $targetLanguage)
            <tr>
                <td>{{ $targetLanguage->id }}</td>
                <td>{{ $targetLanguage->target_language }}</td>
                <td>{{$targetLanguage->part ? \Modules\AdaptiveLearning\Entities\TargetLanguage::PARTS[$targetLanguage->part] : '' }}</td>
                <td>{{$targetLanguage?->explain }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['targetLanguages.destroy', $targetLanguage->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('targetLanguages.show', [$targetLanguage->id]) }}"
                           class='btn btn-primary'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('targetLanguages.edit', [$targetLanguage->id]) }}"
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
