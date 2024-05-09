<div class="card w-100 card-default">
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <form action="" method="get" class="w-100">
                <div class="col-12 row">
                    <div class="form-group mb-0 col-2">
                        <div class="form-group">
                            <input value="{{ request()->get('name') }}" placeholder="Tên tỉnh" name="name" type="text"
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
                                @foreach(\Modules\Province\Entities\Province::TYPE as $type)
                                    <option {{request()->get('type') == $type ? 'selected' : ''}} value="{{$type}}">{{ $type }}</option>
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
