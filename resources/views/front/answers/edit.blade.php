@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-dark text-white">
                    <h2>
                        <div class="card-header p-3">Edit Answer</div>
                    </h2>

                    <div class="card-body">
                        <form method="POST" action="{{ route('answers.update', $answer->id) }}">
                            @csrf
                            
                            @if (session('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif

                            <div class="form-group pb-2">
                                <label for="body" style="font-size: 1.2rem">Body</label>
                                <input type="text" name="body" class="bg-dark text-white form-control @error('title') is-invalid @enderror"
                                    id="body" value="{{ $answer->body }}">
                                @error('body')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
