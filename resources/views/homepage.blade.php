@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 mr-4">
            <h2 class="mt-2 text-center">Top Questions</h2>
            <hr>
            @forelse ($questions as $question)
            <div class="card bg-dark text-white mt-3">
                <div class="card-body">
                    <a class="text-white" href="{{ route('questions.show', ['id' => $question->id, 'slug' => $question->slug]) }}">

                        <div class="row">
                            @livewire('question-votes', ['question' => $question])

                            <div class="col-md-10" style="vertical-align: middle; display: flex; align-items: center">
                                <a class="text-white" href="{{ route('questions.show', ['id' => $question->id, 'slug' => $question->slug]) }}">
                                    <h3>{{ $question->title }}</h3>
                                </a>
                            </div>
                        </div>

                    </a>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="ml-3">
                            <i class="fas fa-clock"></i> Asked: {{ $question->created_at->diffForHumans() }}
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
                    <a style="font-size: 1.1rem" class="text-white badge badge-secondary" href="{{ route('questions.with.tag', $tag->title) }}">
                        {{ $tag->title }}
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
            @empty
            <div class="card">
                <div class="card-body">
                    <h3>There are no questions yet</h3>
                </div>
            </div>
            @endforelse


            @if ($questions->count() > 0)
            <div class="mt-2">
                {{ $questions->links() }}
            </div>
            @endif

        </div>

        <div class="col-md-4 mt-4 ml-4">
            {{-- Sidebar: Most Viewed Questions --}}
            <div class="row">
                @if ($mostViewedQuestions->count() == 5)
                <h3 class="mt-2 text-center mb-4">Most Viewed Questions</h3>
                <div class="card bg-dark" style="width: 20rem;">
                    @foreach ($mostViewedQuestions as $question)
                    <div class="card-header">
                        <a class="text-white" href="{{ route('questions.show', ['id' => $question->id, 'slug' => $question->slug]) }}">
                            {{ $question->title }}
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Sidebar: Search Column --}}
            <div class="row mr-5">
                <div class="card-body">
                    <form action="{{ route('search.results') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="search"></label>
                            <input type="text" class="form-control bg-dark text-white" name="search" required>
                            <button type="submit" class="btn btn-primary mt-2">Search</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection