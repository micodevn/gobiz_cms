@push('page_scripts')
    <style>
        .swal2-container .select2 {
            display: none !important;
        }
    </style>
    @if(session()->has(\App\Http\Controllers\Controller::DEFAULT_KEY_MESSAGE))
        <script>
            console.log("msg: ", 444);
            $(document).ready(function () {
                let msg = '{!! session()->get(\App\Http\Controllers\Controller::DEFAULT_KEY_MESSAGE) !!}';
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: msg,
                    timer: 5000
                });
            });
        </script>
    @endif
    @if(session()->has(\App\Http\Controllers\Controller::DEFAULT_KEY_MESSAGE_ERROR))
        <script>
            $(document).ready(function () {
                let msg = '{!! session()->get(\App\Http\Controllers\Controller::DEFAULT_KEY_MESSAGE_ERROR) !!}';
                console.log("msg: ", msg);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: msg,
                    timer: 5000
                });
            });
        </script>
    @endif

@endpush
