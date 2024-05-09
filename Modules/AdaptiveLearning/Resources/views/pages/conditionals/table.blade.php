<?php

//dd($conditionals);
?>

<div class="table-responsive">
    <table class="table" id="conditionals-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>@lang('models/skillVerb.fields.is_active')</th>
            <th colspan="3">@lang('crud.action')</th>
        </tr>
        </thead>
        <tbody>
         @foreach($conditionals as $conditional)
            <tr>
                <td>{{$conditional->id}}</td>
                <td>{{ $conditional->name }}</td>
                <td><x-active-status :isActive="$conditional->is_active" /></td>
                <td width="120">
                    {!! Form::open(['route' => ['conditionals.destroy', $conditional->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('conditionals.show', [$conditional->id]) }}"
                           class='btn btn-primary'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('conditionals.edit', [$conditional->id]) }}"
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
