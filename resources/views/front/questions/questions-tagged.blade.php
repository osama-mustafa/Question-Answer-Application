@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" id="old-content">
        <div class="col-md-8">
            <h2 class="mt-2 text-center">Questions tagged [{{ $tag->title }}]</h2>

            @forelse ($taggedQuestions as $question)
            <div class="card bg-dark text-white mt-4">
                <div class="card-body">
                    <a class="text-white" href="{{ route('questions.show', ['id' => $question->id, 'slug' => $question->slug]) }}">
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
                @if ($question->tags->count() > 0)
                <div class="card-header">
                    @foreach ($question->tags as $tag)
                    <a style="font-size: 1.1rem" class="badge badge-secondary" href="{{ route('questions.with.tag', ['tag_name' => $tag->title]) }}">{{ $tag->title }}</a>
                    @endforeach
                </div>
                @endif
            </div>
            @empty
            <div class="card">
                <div class="card-body">
                    <h3>There are no questions with this tag.</h3>
                </div>
            </div>
            @endforelse


            @if ($taggedQuestions->count() > 0)
            <div class="mt-2">
                {{ $taggedQuestions->links() }}
            </div>
            @endif

        </div>
    </div>
</div>
@endsection