<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            {{ Form::open(array('url' => route('parts.index'), 'method' => 'GET')) }}
            <div class="form-group">
                {!! Form::label('name', 'Tiêu đề part') !!}
                {!! Form::text('name', request()->name, ['class' => 'form-control', 'maxlength' => 255]) !!}
            </div>
            <button class="btn btn-primary">Tìm kiếm</button>
            <a class="btn btn-primary" href="{{ route('parts.index') }}">Huỷ</a>
            {{ Form::close() }}
        </div>
    </div>
</div>
