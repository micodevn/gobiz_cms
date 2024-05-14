@extends('layouts.app')

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')


        <div class="card">
            <div class="card-header card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><b>Edit Word</b></h4>
                <div class="flex-shrink-0">
                    <div class="form-check form-switch form-switch-right form-switch-md">
                        <a href="{{ route('words.index') }}" class="btn btn-primary"> <i
                                class="fas fa-list pr-2"></i>
                            Danh sách</a>
                    </div>
                </div>
            </div>
            {!! Form::model($word, ['route' => ['words.update', $word->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('curriculum::pages.words.fields')
                </div>

            </div>


            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('words.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
@endsection
