@if (count($errors) > 0)
    @foreach ($errors->all() as $error)
        <div class="danger red">
            {{$error}}
        </div>
    @endforeach
@endif

@if (session('success'))
    <div class="success green">
        {{session('success')}}
    </div>
@endif

@if (session('error'))
    <div class="data-error"></div>
        {{session('error')}}
    </div>
@endif
