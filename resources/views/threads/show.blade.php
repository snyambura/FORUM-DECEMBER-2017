@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <a href="#">{{ $thread->user->name }}</a> posted
                    <div class="panel-heading">{{$thread->title}}</div>

                    <div class="panel-body">
                        <div class="body">{{$thread->body}}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>
        @if(auth()->check())
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form method="POST" action="{{ $thread->path() .'/replies' }}">
                        {{csrf_field()}}
                        <textarea name="body" id="body" class="form-control" placeholder="Have something to say?"
                                  rows="5">
                        </textarea>

                        <button type="submit" class="btn btn-default">Post</button>
                    </form>
                </div>
            </div>
        @else
            <p class="text-center">Please <a href="{{ route('login') }}"> sign in </a> to participate</p>
        @endif
    </div>
@endsection
