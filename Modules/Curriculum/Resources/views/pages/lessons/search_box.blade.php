<div class="card-body">
    <div class="row">
        <div class="col-md-3">
            {{ Form::open(array('url' => route('lessons.index'), 'method' => 'GET')) }}
            <div class="form-group mb-2">
                {!! Form::label('name', 'Tiêu đề buổi học') !!}
                {!! Form::text('name', request()->name, ['class' => 'form-control', 'maxlength' => 255]) !!}
            </div>
            <button class="btn btn-primary">Tìm kiếm</button>
            {{ Form::close() }}
        </div>
    </div>
</div>
