<?php

namespace Tests\Feature\Questions;

use Tests\TestCase;
use Tests\Feature\Traits\CreateUserTrait;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AskQuestionsTest extends TestCase
{

    use RefreshDatabase, CreateUserTrait;
    private $askQuestionPageRoute = 'questions.create';
    private $storeQuestionRoute = 'questions.store';
    private $authUser;

    public function test_guest_cannot_ask_questions_without_login()
    {
        $response = $this->get(route($this->askQuestionPageRoute));
        $response->assertStatus(302);
        $response->assertSee('login');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_ask_new_question_successfully()
    {
        $this->authUser = $this->createUserForTesting();
        $questionData = [
            'title' => 'test question title',
            'body' => 'test question body',
            'user_id' => $this->authUser->id,
            'tags' => 'tag1,tag2'
        ];
        $response = $this->actingAs($this->authUser)->post(route($this->storeQuestionRoute), $questionData);
        $this->assertDatabaseHas('questions', [
            'title' => 'test question title',
            'body' => 'test question body',
            'user_id' => $this->authUser->id
        ]);
    }
}
