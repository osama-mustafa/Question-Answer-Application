@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if (session('report_success'))
                    <div class="alert alert-success">
                        {{ session('report_success') }}
                    </div>
                @endif

                <div class="card bg-dark text-white">
                    <div class="card-header">
                        <div class="row">

                            @livewire('question-votes', ['question' => $question])

                            <div class="col-md-10 mt-1" style="vertical-align: middle; display: flex; align-items: center">
                                <h1>{{ $question->title }}</h1>
                            </div>
                        </div>
                        <p class="card-subtitle mt-2">
                        <div class="row">
                            <div class="ml-3">
                                <i class="fas fa-clock"></i> Asked: {{ $question->created_at->diffForHumans() }}
                            </div>
                            <div class="ml-3">
                                <i class="fas fa-eye"></i> Views: {{ $question->views }} times
                            </div>
                            <div class="ml-3">
                                <i class="fas fa-user"></i> By:
                                <a href="{{ route('user.public.profile', ['user_id' => $question->user->id, 'user_name' => $question->user->name]) }}"
                                    class="text-white">
                                    {{ $question->user->name }}
                                </a>
                            </div>
                        </div>
                        </p>
                    </div>
                    <div class="card-body">
                        <h3>{{ $question->body }}</h3>
                        <hr>

                        {{-- Edit Question --}}
                        @can('edit', $question)
                            <div class="mr-3" style="display: inline-block">
                                <a class="text-white"
                                    href="{{ route('questions.edit', ['id' => $question->id]) }}"><i
                                        class="fas fa-edit"></i></a>
                            </div>
                        @endcan

                        {{-- Report Question --}}
                        @auth
                            <form method="POST" action="{{ route('questions.report', ['id' => $question->id]) }}"
                                style="display: inline-block">
                                @csrf
                                <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-flag"></i></button>
                            </form>
                        @endauth
                    </div>

                    {{-- Tags Attached with Question --}}
                    @if ($question->tags->count() > 0)
                        <hr>
                        <div>
                            @foreach ($question->tags as $tag)
                                <a href="{{ route('questions.with.tag', $tag->title) }}" style="font-size: 1.1rem"
                                    class="badge badge-secondary ml-2 mb-2">{{ $tag->title }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
                <hr>

                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                {{-- Answers Section --}}

                @forelse ($question->answers as $answer)
                    <div class="card bg-dark text-white mb-2">
                        <div class="card-header">
                            <div class="row">

                                <div class="ml-3">
                                    <i class="fas fa-clock"></i> Answered: {{ $answer->created_at->diffForHumans() }}
                                </div>

                                <div class="ml-3">
                                    <i class="fas fa-user"></i> Answered By:
                                    <a href="{{ route('user.public.profile', ['user_id' => $answer->user->id, 'user_name' => $answer->user->name]) }}"
                                        class="text-white">
                                        {{ $answer->user->name }}
                                    </a>
                                </div>

                                <div class="ml-3">
                                    <i class="fas fa-poll"></i> Votes: {{ $answer->votes }}
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h3>
                                {{ $answer->body }}
                            </h3>
                            <hr>

                            @auth
                                {{-- Edit Answer --}}
                                @can('edit', $answer)
                                    <div class="mr-3" style="display: inline-block">
                                        <a class="text-white" href="{{ route('answers.edit', ['answer_id' => $answer->id]) }}"><i
                                                class="fas fa-edit"></i></a>
                                    </div>
                                @endcan

                                {{-- Delete Answer --}}
                                @if (Auth::user()->isAdministrator())
                                    <form method="POST" action="{{ route('admin.answers.delete', ['id' => $answer->id]) }}"
                                        style="display: inline-block">
                                        @csrf
                                        <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
                                    </form>
                                @endif
                            @endauth

                            @if ($answer->created_at != $answer->updated_at)
                            <hr>
                                <small class="font-italic">
                                    Last updated: {{ $answer->updated_at->diffForHumans() }}
                                </small>
                            @endif
                        </div>
                    </div>
                    <hr>
                @empty
                    <h3 class="alert alert-primary">There are no answers yet</h3>
                    <hr>
                @endforelse

                @if ($question->status == true)
                    <form action="{{ route('answers.store', ['question_id' => $question->id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <h4>
                                <label for="body">Your Answer</label>
                            </h4>
                            <textarea class="form-control bg-dark text-white @error('body') is-invalid @enderror"
                                name="body" cols="30" rows="10"></textarea>
                            @error('body')
                                <div>
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                </div>
                            @enderror
                            <button type="submit" class="btn btn-primary mt-2">Post Your Answer</button>
                        </div>
                    </form>
                @else
                    <h4 class="alert alert-danger">Sorry! Question has no longer accepting new answers.</h4>
                @endif

            </div>
        </div>
    </div>
    </div>
@endsection
