<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            {{ Form::open(array('url' => route('activities.index'), 'method' => 'GET')) }}
            <div class="form-group">
                {!! Form::label('name', 'Tiêu đề') !!}
                {!! Form::text('name', request()->name, ['class' => 'form-control', 'maxlength' => 255]) !!}
            </div>
            <button class="btn btn-primary">Tìm kiếm</button>
            <a class="btn btn-primary" href="{{ route('activities.index') }}">Huỷ</a>
            {{ Form::close() }}
        </div>
    </div>
</div>
