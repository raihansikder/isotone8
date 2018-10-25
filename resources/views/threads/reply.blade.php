@foreach($thread->replies as $reply)
    <li>
        <b><a href="#">{{$reply->owner->name}}</a>
            said {{$reply->created_at->diffForHumans()}}</b>
        {{$reply->body}}
    </li>
@endforeach