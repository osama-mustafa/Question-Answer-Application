@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mt-2 text-center"> Questions Asked By: {{ $user->name }} ({{ $user->questions->count() }})</h2>
                <hr>
                    @forelse ($user_questions as $question)
                        <div class="card bg-dark text-white mt-3">
                            <div class="card-body">
                                <a class="text-white"
                                    href="{{ route('questions.show', ['id' => $question->id, 'slug' => $question->slug]) }}">
                                    <h3>{{ $question->title }}</h3>
                                </a>
                            </div>
                            <div class="card-header">
                                <div class="row">
                                    <div class="ml-3">
                                        <i class="fas fa-poll"></i> Votes: {{ $question->votes }}
                                    </div>
                                    <div class="ml-3">
                                        <i class="fas fa-reply"></i> Answers: {{ $question->answers->count() }}
                                    </div>
                                    <div class="ml-3">
                                        <i class="fas fa-eye"></i> Views: {{ $question->views }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card-body">
                            <h3>There are no questions</h3>
                        </div>
                    @endforelse

                    @if ($user_questions->count() > 0)
                        <div class="mt-2">
                            {{ $user_questions->links() }}
                        </div>
                    @endif
            </div>
        </div>
    </div>
@endsection
