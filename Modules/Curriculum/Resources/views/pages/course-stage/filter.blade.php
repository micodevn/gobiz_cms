<div class="card w-100 card-default">
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <form action="" method="get" class="w-100">
                <div class="col-12 row">
                    <div class="form-group mb-0 col-2">
                        <div class="form-group">
                            <input value="{{ request()->get('name') }}" placeholder="Tên TKB" name="name" type="text"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-0 col-3">
                        <div class="form-group">
                            <select data-placeholder="-- Lộ trình --" name="syllabus_id" class="form-control select2bs4" style="width: 100%;">
                                <option
                                    {{request()->get('syllabus_id') == '' || request()->get('syllabus_id') == null ? 'selected' : ''}} value="">
                                    Lộ trình
                                </option>
                                @foreach($syllabus as $k=>$v)
                                    <option
                                        {{request()->get('syllabus_id') ==  $v->id  ? 'selected' : ''}} value="{{ $v->id }}">{{ $v->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-0 col-2">
                        <div class="form-group">
                            <select data-placeholder="-- Khối lớp --" name="grade" class="form-control select2bs4" style="width: 100%;">
                                <option
                                    {{request()->get('grade') == '' || request()->get('grade') == null ? 'selected' : ''}} value="">
                                    Khối lớp
                                </option>
                                @foreach($grades as $k=>$v)
                                    <option
                                        {{request()->get('grade') ==  $v->code  ? 'selected' : ''}} value="{{ $v->code }}">{{ $v->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-0 col-3">
                        <div class="form-group">
                            <select data-placeholder="-- Phân loại --" name="type" class="form-control select2bs4" style="width: 100%;">
                                <option
                                    {{request()->get('type') == '' || request()->get('type') == null ? 'selected' : ''}} value="">
                                    Phân loại
                                </option>
                                @foreach($types as $k=>$v)
                                    <option
                                        {{request()->get('type') ==  $k  ? 'selected' : ''}} value="{{ $k }}">{{ $v }}</option>
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
