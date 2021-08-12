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


// Admin Routes

Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function() {

    // Admin Home

    Route::get('/home', [HomeController::class, 'index'])->name('admin.home');

    // Questions

    Route::get('/questions', [QuestionController::class, 'index'])->name('admin.questions.index');
    Route::get('/questions/trashed', [QuestionController::class, 'showTrashedQuestions'])->name('admin.questions.trashed');
    Route::get('/questions/{id}/restore', [QuestionController::class, 'restoreTrashed'])->name('admin.questions.restore');
    Route::delete('/questions/{id}/delete', [QuestionController::class, 'destroy'])->name('admin.questions.delete');
    Route::delete('/questions/{id}/force-delete', [QuestionController::class, 'deletePermanently'])->name('admin.questions.force.delete');
    Route::post('/question/{question_id}/close', [QuestionController::class, 'changeStatusToClosed'])->name('question.close');
    Route::post('/question/{question_id}/open', [QuestionController::class, 'changeStatusToOpen'])->name('question.open');

    // Users

    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::post('/users/{id}/update', [UserController::class, 'update'])->name('admin.users.update');
    Route::post('/users/{id}/add-to-admins', [UserController::class, 'addToAdmins'])->name('add.to.admins');
    Route::post('/users/{id}/remove-from-admins', [UserController::class, 'removeFromAdmins'])->name('remove.from.admins');

    // Tags

    Route::get('/tags', [TagController::class, 'index'])->name('admin.tags.index');
    Route::get('/tags/{id}/edit', [TagController::class, 'edit'])->name('admin.tags.edit');
    Route::post('/tags/{id}/update', [TagController::class, 'update'])->name('admin.tags.update');
    Route::post('/tags/{id}/delete', [TagController::class, 'destroy'])->name('admin.tags.delete');
    Route::get('/tags/trashed', [TagController::class, 'showTrashedTags'])->name('admin.tags.trashed');
    Route::get('/tags/{id}/restore', [TagController::class, 'restoreTrashed'])->name('admin.tags.restore');

    // Answers

    Route::get('/answers', [AnswerController::class, 'index'])->name('admin.answers.index');
    Route::post('/answers/{id}/delete', [AnswerController::class, 'destroy'])->name('admin.answers.delete');
    Route::get('/answers/trashed', [AnswerController::class, 'showTrashedAnswers'])->name('admin.answers.trashed');
    Route::get('/answers/{id}/restore', [AnswerController::class, 'restoreTrashed'])->name('admin.answers.restore');
    Route::delete('/answers/{id}/force-delete', [AnswerController::class, 'deletePermanently'])->name('admin.answers.force.delete');


});


// Public Routes

Route::get('/', [HomepageController::class, 'homepage'])->name('homepage');
Route::get('/tags', [HomepageController::class, 'tags'])->name('homepage.tags');
Route::get('/profile/{user_id}/{user_name}', [ProfileController::class, 'publicProfile'])->name('user.public.profile');
Route::get('/questions/tagged/{tag_name}', [QuestionController::class, 'showQuestionsAttachedWithTag'])->name('questions.with.tag');
Route::get('/questions/{id}/{slug}', [QuestionController::class, 'show'])->name('questions.show');
Route::post('/questions/search/', [HomepageController::class, 'search'])->name('search.results');




Route::middleware(['auth'])->group(function () {

    // User Profile Routes

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('edit.profile');
    Route::get('/my-questions', [ProfileController::class, 'showMyQuestions'])->name('show.my.questions');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('update.profile');
    Route::get('/edit-password', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::post('/edit-password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Question & Answer Routes For Authenticated Users

    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions/store', [QuestionController::class, 'store'])->name('questions.store');
    Route::post('/questions/{question_id}/answer', [AnswerController::class, 'store'])->name('answers.store');
    Route::get('/question/{id}/edit/', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::post('/question/{id}/update', [QuestionController::class, 'update'])->name('questions.update');
    Route::post('/questions/{id}/report', [QuestionController::class, 'reportAsInappropriate'])->name('questions.report');


    Route::get('/answers/{answer_id}/edit', [AnswerController::class, 'edit'])->name('answers.edit');
    Route::post('/answers/{answer_id}/update', [AnswerController::class, 'update'])->name('answers.update');

});


