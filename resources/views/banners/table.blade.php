<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="grades-table">
            <thead>
            <tr>
                <th>Tên</th>
                <th>Slug</th>
                <th>Loại</th>
                <th>Ảnh</th>
                <th>Active</th>
                <th colspan="3">Thao tác</th>
            </tr>
            </thead>
            <tbody>
            @foreach($listBanner as $banner)
                <tr>
                    <td>{{ $banner->name }}</td>
                    <td>{{ $banner->slug }}</td>
                    <td>{{ $banner->type }}</td>
                    <td><img src="{{$banner->image}}" alt="" width="150px"></td>
                    <td>{!! $banner->is_active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>' !!}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['grades.destroy', $banner->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
{{--                            <a href="{{ route('banners.show', [$banner->id]) }}"--}}
{{--                               class='btn btn-primary'>--}}
{{--                                <i class="fas fa-edit"></i>--}}
{{--                            </a>--}}
                            <a href="{{ route('banners.edit', [$banner->id]) }}"
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

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $listBanner])
        </div>
    </div>
</div>
