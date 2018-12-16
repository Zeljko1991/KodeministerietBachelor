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
                        @if ($ProjectCase->CaseStatus->stage == 'new')
                        <span class="new1 badge left" style="margin-bottom: 5px;">{{$ProjectCase->CaseStatus->stage}}</span>
                        @elseif ($ProjectCase->CaseStatus->stage == 'pricing')
                        <span class="new2 badge left" style="margin-bottom: 5px;">{{$ProjectCase->CaseStatus->stage}}</span>
                        @elseif ($ProjectCase->CaseStatus->stage == 'ongoing')
                        <span class="new3 badge left" style="margin-bottom: 5px;">{{$ProjectCase->CaseStatus->stage}}</span>
                        @elseif ($ProjectCase->CaseStatus->stage == 'completed')
                        <span class="new4 badge left" style="margin-bottom: 5px;">{{$ProjectCase->CaseStatus->stage}}</span>
                        @endif
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
