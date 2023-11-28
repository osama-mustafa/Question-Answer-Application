<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();


// Public Routes

Route::get('/', [HomepageController::class, 'homepage'])->name('homepage');
Route::get('/tags', [HomepageController::class, 'tags'])->name('homepage.tags');
Route::get('/profile/{user_id}/{user_name}', [ProfileController::class, 'publicProfile'])->name('user.public.profile');
Route::get('/questions/tagged/{tag_name}', [QuestionController::class, 'showQuestionsAttachedWithTag'])->name('questions.with.tag');
Route::get('/questions/{id}/{slug}', [QuestionController::class, 'show'])->name('questions.show');
Route::post('/questions/search/', [HomepageController::class, 'search'])->name('search.results');


// Authenticated Users (Non-admins) Routes

Route::middleware(['auth'])->group(function () {

    // User Profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('edit.profile');
    Route::get('/my-questions', [ProfileController::class, 'showMyQuestions'])->name('show.my.questions');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('update.profile');
    Route::get('/edit-password', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::post('/edit-password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Questions
    Route::get('/create-question', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/store-question', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/edit-question/{id}', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::post('/update-question/{id}', [QuestionController::class, 'update'])->name('questions.update');
    Route::post('/report-question/{id}', [QuestionController::class, 'reportAsInappropriate'])->name('questions.report');

    // Answers
    Route::post('/store-answer/{question_id}', [AnswerController::class, 'store'])->name('answers.store');
    Route::get('/edit-answer/{id}', [AnswerController::class, 'edit'])->name('answers.edit');
    Route::post('/update-answer/{id}', [AnswerController::class, 'update'])->name('answers.update');
});


// Admin Routes

Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

    // Admin Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Questions
    Route::resource('questions', QuestionController::class);
    Route::get('/questions/{id}/restore', [QuestionController::class, 'restore'])->name('questions.restore');
    Route::delete('/questions/{id}/force-delete', [QuestionController::class, 'deletePermanently'])->name('questions.force.delete');
    Route::post('/question/{question_id}/close', [QuestionController::class, 'changeStatusToClosed'])->name('questions.close');
    Route::post('/question/{question_id}/open', [QuestionController::class, 'changeStatusToOpen'])->name('questions.open');
    Route::get('/trashed-questions', [QuestionController::class, 'showTrashedQuestions'])->name('questions.trashed');

    // Users
    Route::resource('users', UserController::class);
    Route::post('/users/{id}/add-to-admins', [UserController::class, 'addToAdmins'])->name('add');
    Route::post('/users/{id}/remove-from-admins', [UserController::class, 'removeFromAdmins'])->name('remove');

    // Tags
    Route::resource('tags', TagController::class);
    Route::get('/trashed-tags', [TagController::class, 'showTrashedTags'])->name('tags.trashed');
    Route::get('/tags/{id}/restore', [TagController::class, 'restore'])->name('tags.restore');

    // Answers
    Route::resource('answers', AnswerController::class);
    Route::get('/trashed-answers', [AnswerController::class, 'showTrashedAnswers'])->name('answers.trashed');
    Route::get('/answers/{id}/restore', [AnswerController::class, 'restore'])->name('answers.restore');
    Route::delete('/answers/{id}/force-delete', [AnswerController::class, 'deletePermanently'])->name('answers.force.delete');
});
