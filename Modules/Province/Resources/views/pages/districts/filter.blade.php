<div class="card w-100 card-default">
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <form action="" method="get" class="w-100">
                <div class="col-12 row">
                    <div class="form-group mb-0 col-2">
                        <div class="form-group">
                            <input value="{{ request()->get('name') }}" placeholder="Tên quận/huyện" name="name" type="text"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-0 col-2">
                        <div class="form-group">
                            <input value="{{ request()->get('code') }}" placeholder="Mã tỉnh" name="code" type="text"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-0 col-2">
                        <div class="form-group">
                            <select data-placeholder="-- Loại --" name="type" class="form-control select2bs4" style="width: 100%;">
                                <option {{request()->get('type') == '' || request()->get('type') == null ? 'selected' : ''}}  value="">Loại</option>
                                @foreach(\Modules\Province\Entities\Districts::TYPE as $type)
                                    <option {{request()->get('type') == $type ? 'selected' : ''}} value="{{$type}}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-0 col-2">
                        <div class="form-group">
                            <select data-placeholder="-- Tỉnh/Thành phố --" name="province_code" class="form-control select2bs4" style="width: 100%;">
                                <option {{request()->get('province_code') == '' || request()->get('province_code') == null ? 'selected' : ''}}  value="">Tỉnh/Thành Phố</option>
                                @foreach($provinces as $province)
                                    <option {{request()->get('province_code') == $province ? 'selected' : ''}} value="{{$province->code}}">{{ $province->name }}</option>
                                @endforeach
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
