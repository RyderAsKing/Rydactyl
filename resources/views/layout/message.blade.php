@section('message')
@if(session('message'))
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card corona-gradient-card">
            <div class="card-body py-0 px-0 px-sm-3">
                <div class="row align-items-center">
                    <div class="col-4 col-sm-3 col-xl-2">
                        <img style="margin-left: 15px; padding: 5px" src={{
                            asset('images/file-icons/512/008-archive.png') }} class="gradient-corona-img img-fluid"
                            alt="">
                    </div>
                    <div class="col-5 col-sm-7 col-xl-8 p-0">
                        <p class="mb-0 font-weight-normal d-none d-sm-block">{!! session('message') !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection