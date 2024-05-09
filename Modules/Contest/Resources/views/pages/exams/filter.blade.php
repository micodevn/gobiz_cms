<div class="card w-100 card-default">
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <form action="" method="get">
                <div class="row">
                    <div class="form-group mb-0 col-sm-4 col-md-2">
                        {!! Form::label('title','Tên') !!}
                        {!! Form::text('title', request()->get('title'), ['class' => 'form-control','required' => 'required', 'placeholder' => 'Tên bài thi']) !!}
                    </div>
                    <div class="form-group mb-0 col-sm-4 col-md-2">
                        <label for="subject_id">Môn học</label>
                        <select data-placeholder="-- Môn học --" name="subject_id" class="form-control select2bs4"
                                style="width: 100%;">
                            <option
                                {{request()->get('subject_id') == '' || request()->get('subject_id') == null ? 'selected' : ''}}  value="">
                                Loại
                            </option>
                            @foreach($subjects as $subject)
                                <option
                                    {{request()->get('subject_id') == $subject->id ? 'selected' : ''}} value="{{$subject->id}}">{{ $subject->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0 col-sm-4 col-md-2">
                        {!! Form::label('start_time','Thời gian bắt đầu') !!}
                        {!! Form::datetimelocal('start_time', request()->get('start_time'), ['class' => 'form-control', 'placeholder' => 'Thời gian bắt đầu']) !!}
                    </div>
                    <div class="form-group mb-0 col-sm-4 col-md-2">
                        {!! Form::label('end_time','Thời gian kết thúc') !!}
                        {!! Form::datetimelocal('end_time', request()->get('end_time'), ['class' => 'form-control', 'placeholder' => 'Thời gian kết thúc']) !!}
                    </div>
                    <div class="form-group mb-0 col-sm-4 col-md-2">
                        <label for="status">Trạng Thái</label>
                        <select data-placeholder="-- Trạng thái --" name="status" class="form-control select2bs4"
                                style="width: 100%;">
                            <option
                                {{request()->get('status') == '' || request()->get('status') == null ? 'selected' : ''}}  value="">
                                Trạng thái
                            </option>
                            <option
                                {{request()->get('status') == '' || request()->get('status') == 1 ? 'selected' : ''}}  value="">
                                On
                            </option>
                            <option
                                {{request()->get('status') == '' || request()->get('status') == 0 ? 'selected' : ''}}  value="">
                                Off
                            </option>
                        </select>
                    </div>
                    <div class="form-group mb-0 col-sm-4 col-md-2 align-self-end">
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
