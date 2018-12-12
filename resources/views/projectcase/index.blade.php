@extends('layouts.app')

@section('content')
    <div class="row center">
        <div class="card center col s12 m6 offset-m3">
            <div class="card-content">
                <a href="/projectcase/create" class="waves-effect waves-light btn-large"><i class="left material-icons">add</i>Create Project</a>
            </div>
        </div>
        @if (count($ProjectCases) > 0)
            <div class="card center col s12 m6 offset-m3">
                @foreach ($ProjectCases as $ProjectCase)
                    <div class="card-content row">
                    <span class="badge left">{{$ProjectCase->CaseStatus->stage}}</span>
                    <a href="/projectcase/{{$ProjectCase->id}}" class="waves-effect waves-light btn-large col s12">{{$ProjectCase->title}}</a>
                    </div>
                    @if (!$loop->last)
                        <hr>
                    @endif
                @endforeach
                {{$ProjectCases->links()}}
            </div>
        @else
        <div class="row">
            <div class="card col s12 m6 offset-m3">
                <p>No projects found</p>
            </div>
        </div>
        @endif
    </div>
@endsection
