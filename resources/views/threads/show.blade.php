@extends('layouts.app')

<?php

/** @var $thread \App\Thread */
?>

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Forum Threads</div>

                    <div class="card-body">
                        <article>
                            <h4>{{$thread->title}}</h4>
                            <div class="body">{{$thread->body}}</div>
                        </article>

                        <ul>
                           @include('threads.reply')
                        </ul>
                        <hr/>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->check())
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form method="post" action="{{route('replies.store',[$thread->channel->slug,$thread->id])}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Have something to say?"
                                      rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Post</button>
                    </form>
                </div>
            </div>

        @else
            <p class="text-center">Please <a href="{{route('login')}}">sign in</a> to participate in discussion.</p>
        @endif
    </div>
@endsection
