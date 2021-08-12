@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row mb-2 ml-3">
        <h2>Tags</h2>
    </div>
    <div class="row mb-1 ml-3" style="width: 70%; font-size:1rem">
        <p>
            A tag is a keyword or label that categorizes your question with other, similar questions. Using the right tags makes it easier for others to find and answer your question.
        </p>
    </div>
    <div class="row">
        <div class="col">
            <div class="container-fluid">
                
                <div class="row">
                    @if ($tags->count() > 0)
                        @foreach ($tags as $tag)
                        <div class="col-xl-3 col-md-6">
                            <div class="card text-white bg-dark mb-3" >
                                <div class="card-header">
                                    Questions: ({{  $tag->questions->count() }})</div>
                                <div class="card-body">
                                    <a style="font-size: 1.1rem" class="text-white badge badge-secondary mt-1"
                                         href="{{ route('questions.with.tag', ['tag_name' => $tag->title]) }}">
                                        {{ $tag->title }}
                                    </a>
                                    <p class="card-text mt-2">
                                        {{ $tag->description }}
                                    </p>
                                </div>
                            </div>
                        </div>    
                        @endforeach
                    @endif
                </div>
                <div>
                    {{ $tags->links() }}
                </div>

            </div>
        </div>
    </div>
</div>



@endsection


