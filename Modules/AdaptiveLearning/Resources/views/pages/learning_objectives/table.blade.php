<?php
//dd($learningObjectives);
?>

<div class="table-responsive">
    <table class="table" id="learningObjectives-table">
        <thead>
        <tr>
            <th>@lang('models/learningObjectives.fields.id')</th>
        <th>@lang('models/learningObjectives.fields.explain')</th>
        <th>@lang('models/learningObjectives.fields.code')</th>
        <th>@lang('models/learningObjectives.fields.verb')</th>
        <th>@lang('models/learningObjectives.fields.goal')</th>
        <th>@lang('models/learningObjectives.fields.conditional')</th>
            <th colspan="3">@lang('crud.action')</th>
        </tr>
        </thead>
        <tbody>
         @foreach($learningObjectives as $learningObjective)
{{--             @php--}}
{{--             dd($learningObjective->learningConditional);--}}
{{--             @endphp--}}
            <tr>
                <td>{{ $learningObjective->id }}</td>
            <td>{{ $learningObjective->explain}}</td>
            <td>{{ $learningObjective->code }}</td>
            <td>{{ $learningObjective->skillVerb?->name }}</td>
            <td>{{ $learningObjective->learningGoal?->name }}</td>
            <td>{{ $learningObjective->learningConditional?->name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['learningObjectives.destroy', $learningObjective->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('learningObjectives.show', [$learningObjective->id]) }}"
                           class='btn btn-primary'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('learningObjectives.edit', [$learningObjective->id]) }}"
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
