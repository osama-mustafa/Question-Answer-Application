@extends('layouts.admin')

@section('content')
    <div class="row">
        <h2 class="mt-3">Edit Tag</h2>
    </div>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                <ul>
                    <li>
                        {{ $error }}
                    </li>
                </ul>
            </div>
        @endforeach
    @endif


    <div class="row">
        <form action="{{ route('admin.tags.update', ['id' => $tag->id]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" value="{{ $tag->title }}" class="form-control bg-dark text-white">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control bg-dark text-white" id="" cols="30"
                    rows="10">{{ $tag->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

@endsection
