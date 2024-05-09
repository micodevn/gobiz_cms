<?php

//dd($skillVerbs);
?>

<div class="table-responsive">
    <table class="table" id="skillVerbs-table">
        <thead>
        <tr>
            <th>@lang('models/skillVerb.fields.id')</th>
            <th>@lang('models/skillVerb.fields.label')</th>
            <th>@lang('models/skillVerb.fields.parent')</th>
            <th>@lang('models/skillVerb.fields.is_active')</th>
            <th colspan="3">@lang('crud.action')</th>
        </tr>
        </thead>
        <tbody>
         @foreach($skillVerbs as $skillVerb)
            <tr>
                <td>{{$skillVerb->id}}</td>
                <td>{{ $skillVerb->name }}</td>
                <td>{{ $skillVerb->parent?->name }}</td>
                <td><x-active-status :isActive="$skillVerb->is_active" /></td>
                <td width="120">
                    {!! Form::open(['route' => ['skillVerbs.destroy', $skillVerb->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('skillVerbs.show', [$skillVerb->id]) }}"
                           class='btn btn-primary'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('skillVerbs.edit', [$skillVerb->id]) }}"
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
