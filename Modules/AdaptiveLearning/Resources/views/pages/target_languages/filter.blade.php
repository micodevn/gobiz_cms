<div class="row mb-2 justify-content-between mx-3">
    <div class="card w-100 card-default">

        <div class="card-body">
            <div class="row">
                <form action="" method="get" class="w-100">
                    @csrf
                    <div class="col-12 row">
                        <div class="form-group mb-0 col-1">
                            <div class="form-group">
                                <input value="{{request()->get('id')}}" placeholder="ID" name="id" type="number" min="0"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-0 col-2">
                            <div class="form-group">
                                <input value="{{request()->get('target_language')}}" placeholder="Target Lanuguage"
                                       name="target_language" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-0 col-2">
                            <div class="form-group">
                                <select name="part" class="form-control select2bs4" style="width: 100%;">
                                    <option {{request()->get('part') == '' || request()->get('part') == null ? 'selected' : ''}} value="">
                                        Choose Part
                                    </option>
                                    @foreach(\Modules\AdaptiveLearning\Entities\TargetLanguage::PARTS as $k=>$v)
                                        <option {{request()->get('part') ==  $k  ? 'selected' : ''}} value="{{ $k }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-0 col-1">
                            <button type="submit" class="btn color-edupia"><i class="fas fa-search"></i>
                                {{--                                <span class="search-filter-text">Search</span>--}}
                            </button>
                        </div>
                    </div>
                </form>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
    <!-- /.card -->
</div>
