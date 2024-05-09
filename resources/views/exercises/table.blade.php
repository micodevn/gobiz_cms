<div class="table-responsive">
    <table class="table" id="exercises-table">
        @include('exercises.filter')
        <thead>
        <tr>
            <th>@lang('models/exercises.fields.id')</th>
            <th>@lang('models/exercises.fields.name')</th>
            <th>@lang('models/exercises.fields.description')</th>
{{--            <th>@lang('models/exercises.fields.lesson_id')</th>--}}
            <th>Thời gian hiển thị</th>
            <th>@lang('models/exercises.fields.type')</th>
            <th>@lang('models/exercises.fields.is_active')</th>
            <th colspan="3">@lang('crud.action')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($exercises as $exercise)
            <?php
            $topic = '';
                if(!empty($exercise->topics)) {
                    $topics = $exercise->topics->pluck('topic_id');
                    $topics = count($topics) ? $topics : '';
                }
            ?>
            <tr>
                <td>{{ $exercise->id }}</td>
                <td>{{ $exercise->name }}</td>
                <td>{{ $exercise->description }}</td>
{{--                <td>{{ $exercise->lesson_id }}</td>--}}
                <td>{{ $exercise->duration_show }}</td>
                <td>{{ $exercise->type?->name }}</td>
                <td>
                    <x-active-status :isActive="$exercise->is_active"/>
                </td>
                <td width="120">
                    {!! Form::open(['route' => ['exercises.destroy', $exercise->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('exercises.edit', [$exercise->id]) }}"
                           class='btn btn-primary'>
                            <i class="far fa-edit"></i>
                        </a>
                        <a href="{{ route('exercises.replicate', ['id'=>$exercise->id]) }}"
                           class='btn btn-warning'>
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
            @if(isset($exercises) && count($exercises))
                {{ $exercises->appends(request()->input())->links() }}
            @endif
        </div>
    </div>
</div>
