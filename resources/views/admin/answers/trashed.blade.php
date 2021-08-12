@extends('layouts.admin')

@section('content')
    <div class="row">
        <h2 class="mt-3">Trashed Answers</h2>
    </div>
    <hr>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if ($answers->count() > 0)
        <div class="row m-3">

            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">Answer</th>
                        <th scope="col">Answerd By</th>
                        <th scope="col">Restore</th>
                        <th scope="col">Delete</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($answers as $answer)
                        <tr>
                            <td> {{ Str::words($answer->body, 5, '...') }} </td>
                            <td>
                                <a class="text-white"
                                    href="{{ route('user.public.profile', ['user_id' => $answer->user->id, 'user_name' => $answer->user->name]) }}">
                                    {{ $answer->user->name }}
                            </td>
                            </a>
                            <td>
                                <a class="btn btn-primary btn-sm"
                                    href="{{ route('admin.answers.restore', ['id' => $answer->id]) }}">Restore
                                    <i class="fas fa-trash-restore"></i>
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('admin.answers.force.delete', ['id' => $answer->id]) }}" method="POST">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash-restore"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $answers->links() }}
        </div>
    @else
        <div>
            <h3>There are no trashed answers.</h3>
        </div>
    @endif
@endsection
