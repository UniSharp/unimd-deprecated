@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if(count($notes))
                    <ul>
                        @foreach($notes as $note)
                        <li><a href="{{route('note.edit', $note->id)}}" target="_blank">Note {{$note->id}}</li>
                        @endforeach
                    </ul>
                    @else
                    There are no notes now.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
