<div class="table-responsive">
    <table class="table" id="files-table">
        <thead>
        <tr>
            <th>@lang('models/files.fields.id')</th>
{{--            <th>@lang('models/files.fields.icon')</th>--}}
            <th>@lang('models/files.fields.name')</th>
            <th>@lang('models/files.fields.type')</th>
            <th>View</th>
            <th>@lang('models/files.fields.is_active')</th>
            <th>@lang('models/files.fields.created_at')</th>
            <th>@lang('models/files.fields.updated_at')</th>
{{--            <th>@lang('models/files.fields.created_by')</th>--}}
            <th colspan="3">@lang('crud.action')</th>
        </tr>
        </thead>
        <tbody>
         @foreach($files as $file)
            <tr>
                <td>{{ $file->id }}</td>
{{--                <td >--}}
{{--                    <img width="70px" height="70px" style="object-fit: contain" src="{{ $file->icon_file_path_url }}" alt="">--}}
{{--                </td>--}}
                <td>{{ $file->name }}</td>
                <td>{{ $file->type }}</td>
                @php $path = $file->file_path; @endphp
                <td>
                    @if($file->type == "IMAGE")
                        <img style="width: 100px" src="{{ $path }}" alt="">
                    @elseif($file->type == "VIDEO")
                        <video width="100" height="100" controls>
                            <source src="{{$path}}" type="video/mp4">
                            <source src="{{ $path }}" type="video/ogg">
                        </video>
                    @elseif($file->type == "AUDIO")
                        <audio controls style="width: 100px">
                            <source src="{{$path}}" type="audio/ogg">
                            <source src="{{$path}}" type="audio/mpeg">
                        </audio>
                    @endif
                </td>
                <td><x-active-status :isActive="$file->is_active" /></td>
                <td>{{ $file->created_at }}</td>
                <td>{{ $file->updated_at }}</td>
{{--                <td>{{ $file->creator->name }}</td>--}}
                <td width="120">
                    {!! Form::open(['route' => ['files.destroy', $file->id], 'method' => 'delete']) !!}
                    <div class='btn-group float-right'>
                        <a href="{{ route('files.edit', [$file->id]) }}"
                           class='btn btn-primary'>
                            <i class="far fa-edit"></i>
                        </a>

                        <a href="{{ route('files.replicate', ['id'=>$file->id]) }}"
                           class='btn btn-primary'>
                            <i class="far fa-copy"></i>
                        </a>

{{--                        <div class="dropdown">--}}
{{--                            <button class="dropdown-toggle btn btn-info" type="button"--}}
{{--                                    id="moreActionButton" data-bs-toggle="dropdown"--}}
{{--                                    aria-haspopup="true" aria-expanded="false">--}}
{{--                            </button>--}}
{{--                            <div class="dropdown-menu" aria-labelledby="moreActionButton">--}}
{{--                                <a class="dropdown-item"--}}
{{--                                   href="{{route('questions.index',[''])}}"--}}
{{--                                   target="_blank">Find with Questions</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}--}}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
         @endforeach
        </tbody>
    </table>
</div>
@push('page_scripts')
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            (function ($) {
                $("#files-table").find('a.show-file').click(function(e) {
                    const url = $(this).data('url');
                    const type = $(this).data('type');

                    filePreviewer.previewFile(url, type);
                });
            })(jQuery);
        });
    </script>
@endpush
