@extends('layouts.app')
@section('content')
    <style>
        .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__rendered {
            min-height: 35px;
        }
        .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
            color: white !important;
            background-color: #4b38b3 !important;
            padding: 4px;
        }
        .select2-selection__clear {
            display: none;
        }
    </style>
{{--    @include('pages.error')--}}
    <div class="card">
        <div class="card-header card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">
                Create District
            </h4>
            <div class="flex-shrink-0">
                <ul class="list-inline card-toolbar-menu d-flex align-items-center mb-0">
                    <li class="list-inline-item">
                        <a href="{{ route('districts.index') }}"
                           class="btn btn-secondary btn-label waves-effect waves-light">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-view-list label-icon align-middle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    List District
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <form action="{{ route('districts.store') }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            <div class="card-body row">
                <div class="col-12">
                    <div class="mb-3">
                        <label>Tên <span class="text-danger">*</span></label>
                        <input value="{{old('name')}}" type="text" class="form-control"
                               required
                               name="name"
                               placeholder="Ex : Thanh Xuân">
                    </div>
                    <div class="mb-3">
                        <label for="course">Loại</label>
                        <select id="type" name="type" class="form-control select2bs4">
                            @foreach(\Modules\Province\Entities\Districts::TYPE as $type)
                                <option value="{{$type}}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Mã quận/huyện <span class="text-danger">*</span></label>
                        <input value="{{old('code')}}" class="form-control"
                               required
                               type="number"
                               name="code"
                               placeholder="Ex: 100">
                    </div>
                    <div class="mb-3">
                        <label for="course">Tỉnh/thành phố</label>
                        <select name="province_code" class="form-control select2bs4">
                            @foreach($provinces as $province)
                                <option value="{{$province->code}}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
    @include('components.toast')
@endsection
