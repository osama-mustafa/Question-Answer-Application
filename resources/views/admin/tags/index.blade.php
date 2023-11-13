@extends('layouts.admin')

@section('content')
<div class="row">
    <h2 class="mt-3">All Tags</h2>
</div>

@if ($tags->count() > 0)
<div class="row m-3">

    @if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif

    <table class="table table-dark">
        <thead>
            <tr>
                <th scope="col">Tag</th>
                <th scope="col">Description</th>
                <th scope="col">Questions</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($tags as $tag)
            <tr>
                <td>
                    <a class="text-white" href="{{ route('questions.with.tag', $tag->title) }}">
                        {{ $tag->title }}
                    </a>
                </td>
                <td>{{ $tag->description }}</td>
                <td>{{ $tag->questions->count() }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('admin.tags.edit', ['tag' => $tag->id]) }}">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </td>
                <td>
                    <form action="{{ route('admin.tags.destroy', ['tag' => $tag->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i> Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $tags->links() }}
</div>
@else
<div>
    <hr>
    <h3>
        There are no tags.
    </h3>
</div>
@endif
@endsection