<?php
//    dd($parents->toArray());
?>

<div class="row mb-2 justify-content-between mx-3">
    <div class="card w-100 card-default">

        <div class="card-body">
            <div class="row">
                <form action="" method="get" class="w-100">
                    @csrf
                    <div class="col-12 row">
                        <div class="form-group mb-0 col-2">
                            <div class="form-group">
                                <input value="{{ request()->get('name') }}" placeholder="Name" name="name" type="text"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-0 col -1">
                            <div class="form-group">
                                <input value="{{ request()->get('code') }}" placeholder="Code" name="code" type="text"
                                       min="0" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-0 col-2">
                            <div class="form-group">
                                <select name="parent_id" class="form-control select2bs4" style="width: 100%;">
                                    <option
                                        {{request()->get('parent') == '' || request()->get('parent') == null ? 'selected' : ''}} value="">
                                        Choose Parent
                                    </option>
                                    @foreach($parents as $k=>$v)
                                        @if($v->parent_id == null)
                                            <option
                                                {{request()->get('parent_id') ==  $v->id  ? 'selected' : ''}} value="{{ $v->id }}">{{ $v->name }}
                                            </option>
                                        @endif
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-0 col-2">
                            <div class="form-group">
                                <select class="form-control select2bs4" name="is_active" style="width: 100%;">
                                    <option value="" selected="selected">Status</option>
                                    <option {{request()->get('status') === '1' ? 'selected' : ''}} value="1">Active
                                    </option>
                                    <option {{request()->get('status') === '0' ? 'selected' : ''}} value="0">DeActive
                                    </option>
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
