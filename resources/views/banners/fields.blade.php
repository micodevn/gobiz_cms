@php
    $banner = $banner ?? new \App\Models\Banner();
    $imageSelected = $banner?->image ? [
    collect([
        'id' => $banner->image,
        'url' => $banner->image,
    'name' => $banner->image
    ])
] : [];
@endphp
    <!-- Title Field -->
<div class="form-group col-sm-6">
    <label>Tên banner <span class="text-danger">*</span></label>
    <input value="{{$banner->name ? $banner->name :  old('name')}}" type="text" class="form-control" required
           name="name"
           placeholder="Nhập tên banner">
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    <label>Url <span class="text-danger">*</span></label>
    <input value="{{$banner->url ? $banner->url :  old('url')}}" type="text" class="form-control" name="url"
           placeholder="Nhập url">
</div>

<div class="form-group col-sm-6">
    <label>Slug <span class="text-danger"></span></label>
    <input value="{{$banner->slug ? $banner->slug :  old('slug')}}" type="text" class="form-control" name="slug"
           placeholder="slug">
</div>

<div class="form-group col-sm-6">
    <label>Platform <span class="text-danger">*</span></label>
    <select name="platform" class="form-control select2bs4 required" style="width: 100%;">
        <option value="1" {{$banner->platform === 1 ? 'selected' :  ''}}>Web</option>
        <option value="2" {{$banner->platform === 2 ? 'selected' :  ''}}>App</option>
    </select>
</div>



<!-- Level Field -->
<div class="form-group col-sm-6">
    <div class="mb-3">
        <label for="image">Ảnh <span class="text-danger"></span></label>
        <x-api-select
            :url="route('api.file.search')"
            name="image"
            :selected="$imageSelected"
            placeholder="Search ảnh"
            class="file-list select-list"
            value-field="url"
        ></x-api-select>
    </div>
    @if($banner->image)
        <div class="mb-3">
            <div style="width: 170px;height: 170px;">
                <img src="{{ $banner->image }}" alt="" class="img_exam_month pt-1"
                     style="width: 100%;height: 100%;object-fit: contain;background: gray;">
            </div>
        </div>
    @endif
</div>

<!-- Subjects Field -->
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('subjects[]', 'Môn học:') !!}--}}
{{--    {!! Form::select('subjects[]', $subjects, null, ['multiple' => true, 'class' => 'form-control', 'required']) !!}--}}
{{--</div>--}}

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    <div class="col-sm-3">
        <div>
            {!! Form::label('is_active', 'Trạng thái:', []) !!}
        </div>
        {!! Form::hidden('is_active', 0, false) !!}
        {!! Form::checkbox('is_active', 1, $banner->is_active,  ['data-toggle' => 'toggle']) !!}
    </div>
</div>
