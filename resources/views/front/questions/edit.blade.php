@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-white">
                <h2>
                    <div class="card-header p-3">Edit Question</div>
                </h2>

                <div class="card-body">
                    <form method="POST" action="{{ route('questions.update', ['id' => $question->id]) }}">
                        @csrf
                        @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                        @endif
                        @csrf
                        <div class="form-group pb-2">
                            <label for="title" style="font-size: 1.2rem">Title</label>
                            <div>
                                <small>Be specific and imagine you are asking a question to another person</small>
                            </div>
                            <input type="text" name="title" class="bg-dark text-white form-control @error('title') is-invalid @enderror" id="title" value="{{ $question->title }}">
                            @error('title')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="body" style="font-size: 1.2rem">Body</label>
                            <div>
                                <small>Include all the information someone would need to answer your question</small>
                            </div>
                            <textarea class="bg-dark text-white form-control @error('body') is-invalid @enderror" id="body" name="body" rows="3">{{ $question->body }}</textarea>
                            @error('body')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tags" style="font-size: 1.2rem">Tags</label>
                            <div>
                                <small>Add up to 5 tags separated with comma to describe what your question is about</small><br>
                                <small><span class="text-danger">*</span> If you add more than 5 tags, all of them will be ignored</small>

                            </div>
                            <input class="form-control bg-dark text-white" type="text" name="tags" value="{{ $tags }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection