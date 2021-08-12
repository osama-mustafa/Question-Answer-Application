@extends('layouts.admin')

@section('content')
    <div class="row">
        <h2 class="mt-3">All Tags</h2>
    </div>
    <hr>
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if ($tags->count() > 0)
        <div class="row m-3">


            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">Tag</th>
                        <th scope="col">Questions</th>
                        <th scope="col">Restore</th>
                        <th scope="col">Delete</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($tags as $tag)
                        <tr>
                            <td>
                                <a class="text-white"
                                    href="{{ route('questions.with.tag', ['tag_name' => $tag->title]) }}">
                                    {{ $tag->title }}
                                </a>
                            </td>
                            <td>{{ $tag->questions->count() }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm"
                                    href="{{ route('admin.tags.restore', ['id' => $tag->id]) }}">
                                    <i class="fas fa-trash-restore"></i> Restore</a>
                            </td>
                            <td>
                                <form action="">
                                    <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i>
                                        Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $tags->links() }}
        </div>
    @else
        <h3>There are no trashed tags.</h3>
    @endif
@endsection
