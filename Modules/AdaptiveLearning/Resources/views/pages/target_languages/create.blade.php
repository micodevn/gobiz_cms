@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                     @lang('models/targetLanguages.singular')
                </div>
            </div>
        </div>
    </section>

    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="card">
            {!! Form::open(['route' => 'targetLanguages.store']) !!}
            <div class="card-body">
                <div class="row">
                    @include('adaptivelearning::pages.target_languages.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('targetLanguages.index') }}" class="btn btn-default">
                 @lang('crud.cancel')
                </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
@push('page_scripts')
    <script src="/storage/js/init-selected-api.js" defer></script>
@endpush
