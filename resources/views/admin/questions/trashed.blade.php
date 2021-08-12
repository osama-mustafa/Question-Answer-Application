@extends('layouts.admin')

@section('content')
    <div class="row">
        <h2 class="mt-3">Trashed Questions</h2>
    </div>

    @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

    @if ($questions->count() > 0)
        <div class="row m-3">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">Question</th>
                        <th scope="col">User</th>
                        <th scope="col">Asked</th>
                        <th scope="col">Answers</th>
                        <th scope="col">Change Status</th>
                        <th scope="col">Restore</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $question)
                        <tr>
                            <td>
                                <a
                                   class="text-white" href="{{ route('questions.show', ['id' => $question->id, 'slug' => $question->slug]) }}">
                                    {{ $question->title }}
                                </a>
                            </td>
                            <td>
                                <a class="text-white" href="{{ route('user.public.profile',
                                    ['user_id' => $question->user->id, 'user_name' => $question->user->name]) }}">
                                    {{ $question->user->name }}
                                </a>
                            </td>
                            <td>{{ $question->created_at->diffForHumans() }}</td>
                            <td>{{ $question->answers->count() }}</td>
                            <td>
                                @if ($question->status == true)
                                    <form action="{{ route('question.close', ['question_id' => $question->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-secondary btn-sm">Close <i class="fas fa-lock"></i></button>
                                    </form>
                                @else
                                    <form action="{{ route('question.open', ['question_id' => $question->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-primary btn-sm">Open <i class="fas fa-unlock"></i></button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" 
                                    href="{{ route('admin.questions.restore', ['id' => $question->id]) }}">Restore 
                                    <i class="fas fa-trash-restore"></i>
                                </a>
                            </td>
                            <td>
                            <form action="{{ route('admin.questions.force.delete', ['id' => $question->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Delete <i
                                        class="fas fa-trash"></i>
                                </button>
                            </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $questions->links() }}
        </div>
    @else 
    <hr>
        <h3>There are no trashed questions</h3>
    @endif
@endsection
