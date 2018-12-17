@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-content">
    <span class="card-title">Case: <strong>{{$ProjectCase->title}}</strong><span class="badge">{{$ProjectCase->CaseStatus->stage}}</span></span>
            <div>Description: {!!$ProjectCase->description!!}</div>
            <small>Created at: {{$ProjectCase->created_at}}</small>
            <div class="card-action">
                {!!Form::open(['action' => ['ProjectCaseController@destroy', $ProjectCase->id], 'method' => 'POST', 'class', 'id' => 'delcase'])!!}
                    <a href="/subcase/create/{{$ProjectCase->id}}" class="btn"><i class="left material-icons">add</i>Create Subcase</a>
                    <a href="/projectcase/{{$ProjectCase->id}}/edit" class="btn">Edit</a>
                    {{Form::hidden('_method', 'DELETE')}}
                    {{Form::submit('Delete', ['class' => 'btn red', 'onclick' => 'confirmDeleteCase(event)'])}}
                {!!Form::close()!!}
            </div>
    </div>
</div>

<ul class="collapsible">
    @if (count($SubCases) > 0)
        @foreach ($SubCases as $SubCase)
        <li>
            <div class="collapsible-header">
                <strong>{{$SubCase->title}}</strong>
            <span class="badge">{{$SubCase->CaseStatus->stage}}</span>
            </div>
            <div class="collapsible-body">
                <div class="row">
                    <strong>Description:</strong>
                    {!!$SubCase->description!!}
                </div>
                <hr>
                <div class="row">
                    <strong>Deliverables:</strong>
                    @if (count($SubCase->deliverables) > 0)
                        @foreach ($SubCase->deliverables as $deliverable)
                            <h5><i class="material-icons">assessment</i> {!!$deliverable->title!!}</h5>
                        @endforeach
                    @endif
                    <hr>
                    <p>
                        <strong>Price:</strong>
                        {!!$SubCase->price!!}
                    </p>
                </div>
                {!!Form::open(['action' => ['SubCaseController@destroy', $SubCase->id], 'method' => 'POST', 'class', 'id' => $SubCase->id])!!}
                    <a href="/subcase/{{$SubCase->id}}/edit" class="btn">Edit</a>
                    <a href="/planning/{{$SubCase->id}}" class="btn">Plan</a>
                    {{Form::hidden('_method', 'DELETE')}}
                    {{Form::submit('Delete', ['class' => 'btn red fak', 'id' => 'del'.$SubCase->id])}}
                {!!Form::close()!!}
            </div>
        </li>
        @endforeach
    @else
        <li>
            <div class="collapsible-header"><strong>There are no subcases for this case</strong></div>
        </li>
    @endif

</ul>
<script>
    function confirmDeleteCase(event) {
        event.preventDefault();
        return swal({
            title: "Are you sure you want to delete this case?",
            text: "There won't be any going back!",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false
        }).then((result) => {
                if(result.value) {
                    document.getElementById("delcase").submit();
                }
            });
        }
</script>
@endsection
