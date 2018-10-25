@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Forum Threads</div>
                    <div class="card-body">
                        <form method="POST" action="{{route('threads.store')}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="title">Body:</label>
                                <textarea name="body" id="body" class="form-control" placeholder="" rows="8"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
