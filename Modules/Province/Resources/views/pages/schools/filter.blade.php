<div class="card w-100 card-default">
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <form action="" method="get" class="w-100">
                <div class="col-12 row">
                    <div class="form-group mb-0 col-2">
                        <div class="form-group">
                            <input value="{{ request()->get('name') }}" placeholder="Tên trường" name="name" type="text"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-0 col-2">
                        <div class="form-group">
                            <select data-placeholder="-- Tỉnh/Thành phố --" name="province_code"
                                    class="form-control select2bs4 province_code" style="width: 100%;">
                                <option
                                    {{request()->get('province_code') == '' || request()->get('province_code') == null ? 'selected' : ''}}  value="">
                                    Tỉnh/Thành phố
                                </option>
                                @foreach($provinces as $province)
                                    <option
                                        {{request()->get('province_code') == $province->code ? 'selected' : ''}} value="{{$province->code}}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-0 col-2">
                        <div class="form-group">
                            <select data-placeholder="-- Quận/Huyện --" name="district_code"
                                    class="form-control select2bs4 district_code" style="width: 100%;">
                                <option
                                    {{request()->get('district_code') == '' || request()->get('district_code') == null ? 'selected' : ''}}  value="">
                                    Quận/Huyện
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-0 col-1">
                        <button type="submit" class="btn btn-secondary"><i
                                class="mdi mdi-magnify search-widget-icon"></i>
                        </button>
                    </div>
                </div>
            </form>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
</div>

@push('script')
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            (function ($) {
                $('.province_code').on('change', function (e) {
                    $.ajax({
                        url: '{!! route('provinces.load-districts') !!}',
                        data: {province_code: this.value, district_code: '{!! request()->get('district_code') !!}'},
                        type: 'get',
                        success: function (response) {
                            $(".district_code").html(response.data)
                        },
                        error: function (response) {
                            console.log(response)
                        }
                    });
                }).change()

            })(jQuery)
        });
    </script>
@endpush
