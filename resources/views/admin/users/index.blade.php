@extends('layouts.admin')

@section('content')
    <div class="row">
        <h2 class="mt-3">All Users</h2>
    </div>

    @if ($users->count() > 0)
        <div class="row m-3">

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">User</th>
                        <th scope="col">Email</th>
                        <th scope="col">Questions</th>
                        <th scope="col">Answers</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Admin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <a class="text-white"
                                    href="{{ route('user.public.profile', ['user_id' => $user->id, 'user_name' => $user->name]) }}">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->questions->count() }}</td>
                            <td>{{ $user->answers->count() }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm"
                                    href="{{ route('admin.users.edit', ['id' => $user->id]) }}">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                            @if ($user->isAdministrator())
                                <td>
                                    <form action="{{ route('remove.from.admins', $user->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-danger btn-sm" type="submit">
                                            <i class="fas fa-user-lock"></i> Remove from admins
                                        </button>
                                    </form>
                                </td>
                            @else
                                <td>
                                    <form action="{{ route('add.to.admins', $user->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-success btn-sm" type="submit">
                                            <i class="fas fa-user-shield"></i> Add to admins
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    @endif
@endsection
