@extends('layouts.app')

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="card">
            <div class="card-header card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><b>Edit Exercise</b></h4>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        @if(!empty($exercise->questions) && count($exercise->questions))
                            <div class="col-sm-6">
                                <div class="float-right">
                                    <div class="dropdown">
                                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownQuestions"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Edit Questions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownQuestions">
                                            @foreach($exercise->questions as $val)
                                                <a class="dropdown-item"
                                                   href="{{ route('questions.edit', [$val->id]) }}">{{$val->name}}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('exercises.index') }}" class="btn btn-primary"> <i
                                class="fas fa-list pr-2"></i>
                            List Exercise</a>
                    </div>
                </div>
            </div>
            {!! Form::model($exercise, ['route' => ['exercises.update', $exercise->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('exercises.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('exercises.index') }}" class="btn btn-default">
                    @lang('crud.cancel')
                </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

@push('page_scripts')
    <script src="/storage/js/init-selected-api.js?v={{config('cdn.version_script')}}" defer></script>
@endpush
