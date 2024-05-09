@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                   @lang('models/targetLanguages.plural')
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('targetLanguages.create') }}">
                         @lang('crud.add_new')
                    </a>
                </div>
            </div>
        </div>
    </section>
    @include('adaptivelearning::pages.target_languages.filter')
    <div class="content">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('adaptivelearning::pages.target_languages.table')

                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', ['records' => $targetLanguages])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


