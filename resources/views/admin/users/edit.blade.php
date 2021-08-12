@extends('layouts.admin')

@section('content')
    <div class="container mt-3">
        <div class="row mb-2">
            <h2>Edit User</h2>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card bg-dark text-white">

                    {{-- <div class="card-header">
                        <h2>Edit User</h2>
                    </div> --}}

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control bg-dark text-white" name="name"
                                    value="{{ $user->name }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control bg-dark text-white" name="email"
                                    value="{{ $user->email }}">
                            </div>
                            <div class="form-group">
                                <label for="work">Work</label>
                                <input type="text" class="form-control bg-dark text-white" name="work"
                                    value="{{ $user->work }}">
                            </div>
                            <div class="form-group">
                                <label for="facebook">Facebook</label>
                                <input type="text" class="form-control bg-dark text-white" name="facebook"
                                    value="{{ $user->facebook }}">
                            </div>
                            <div class="form-group">
                                <label for="linkedin">Linkedin</label>
                                <input type="text" class="form-control bg-dark text-white" name="linkedin"
                                    value="{{ $user->linkedin }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>


@endsection
