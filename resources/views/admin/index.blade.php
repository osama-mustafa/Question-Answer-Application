@extends('layouts.admin')

@section('content')
    <h2 class="m-4 text-secondary">Welcome to Dashboard</h2>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-body">Questions: {{ $questions->count() }}</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.questions.index') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-body">Answers: {{ $answers->count() }}</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.answers.index') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-body">Users: {{ $users->count() }}</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.users.index') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-body">Tags: {{ $tags->count() }}</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.tags.index') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

@endsection