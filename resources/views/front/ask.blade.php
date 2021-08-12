@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-dark mt-3 text-white">
                    <h2>
                        <div class="card-header p-3">Ask a public question</div>
                    </h2>


                    @if (!Auth::user()->exceedDailyQuestionLimit())
                        <div class="card-body">
                            <form method="POST" action="{{ route('questions.store') }}">

                                @if (session('message'))
                                    <div class="alert alert-success">
                                        {{ session('message') }}
                                    </div>
                                @endif

                                @if (session('warning_message'))
                                    <div class="alert alert-danger">
                                        {{ session('warning_message') }}
                                    </div>
                                @endif


                                @csrf
                                <div class="form-group pb-2">
                                    <label for="title" style="font-size: 1.2rem">Title</label>
                                    <div>
                                        <small>Be specific and imagine you’re asking a question to another person</small>
                                    </div>
                                    <input type="text" name="title"
                                        class="form-control bg-dark text-white @error('title') is-invalid @enderror"
                                        id="title" placeholder="e.g. What is the difference between OOP & OOD?">
                                    @error('title')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="body" style="font-size: 1.2rem">Body</label>
                                    <div>
                                        <small>Include all the information someone would need to answer your
                                            question</small>
                                    </div>
                                    <textarea class="form-control bg-dark text-white @error('body') is-invalid @enderror"
                                        id="body" name="body" rows="3"></textarea>
                                    @error('body')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tags" style="font-size: 1.2rem">Tags</label>
                                    <div>
                                        <small>Add up to 5 tags separated with comma
                                             to describe what your question is about
                                        </small><br>
                                        <small><span class="text-danger">*</span> If you add more than 5 tags,
                                             all of them will be ignored
                                        </small>

                                    </div>
                                    <input class="form-control bg-dark text-white" type="text" name="tags">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>

                        </div>
                    @else
                        <div class="card-body">
                            <h3 style="line-height: 2.5rem">
                                <i class="fas fa-frown"></i> Sorry! You have reached the daily limit of questions,
                                kindly try tomorrow, thanks for your patience
                            </h3>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
