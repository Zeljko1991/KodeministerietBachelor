@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-content">
        <span class="card-title">{{$ProjectCase->title}}</span>
            <div>{!!$ProjectCase->description!!}</div>
            <small>{{$ProjectCase->created_at}}</small>
            <div class="card-action">
                {!!Form::open(['action' => ['ProjectCaseController@destroy', $ProjectCase->id], 'method' => 'POST', 'class', 'id' => 'delcon'])!!}
                    <a href="/subcase/create/{{$ProjectCase->id}}" class="btn"><i class="left material-icons">add</i>Create Subcase</a>
                    <a href="/projectcase/{{$ProjectCase->id}}/edit" class="btn">Edit</a>
                    {{Form::hidden('_method', 'DELETE')}}
                    {{Form::submit('Delete', ['class' => 'btn red', 'onclick' => 'confirmDelete(event)'])}}
                {!!Form::close()!!}
            </div>
    </div>
</div>

<ul class="collapsible">
    @foreach ($SubCases as $SubCase)
    <li>
        <div class="collapsible-header"><strong>{{$SubCase->title}}</strong></div>
        <div class="collapsible-body">
            <div class="row">
                <strong>Description:</strong>
                {!!$SubCase->description!!}
            </div>
            <hr>
            <div class="row">
                <strong>Deliverables:</strong>
                <p>{!!$SubCase->deliverables!!}</p>
            </div>
        </div>
    </li>
    @endforeach
</ul>
<script>
    function confirmDelete() {
        event.preventDefault();
        return swal({
            title: "Are you sure you want to delete this case?",
            text: "There won't be any going back!",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false
        }).then((result) => {
                if(result.value) {
                    document.getElementById("delcon").submit();
                }
            });
        }
</script>
@endsection
