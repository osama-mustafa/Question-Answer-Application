<?php

namespace Tests\Feature\Questions;

use App\Models\User;
use Tests\TestCase;
use Tests\Feature\Traits\CreateUserTrait;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class AskQuestionsTest extends TestCase
{

    use RefreshDatabase, CreateUserTrait;
    private $askQuestionPageRoute = 'questions.create';
    private $storeQuestionRoute = 'questions.store';

    public function test_guest_cannot_ask_questions_without_login()
    {
        // Act
        $response = $this->get(route($this->askQuestionPageRoute));

        // Assert
        $response->assertStatus(302);
        $response->assertSee('login');
        $this->assertGuest();
    }

    public function test_ask_questions_page_is_loaded_successfully()
    {
        // Arrange
        $authUser = User::factory()->create();

        // Act
        $response = $this->actingAs($authUser)->get(route($this->askQuestionPageRoute));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('front.ask');
        $response->assertSee('Ask a public question');
    }

    public function test_authenticated_user_can_ask_new_question_successfully()
    {
        // Arrange
        $authUser = User::factory()->create();
        $questionData = [
            'title' => 'test question title',
            'body' => 'test question body',
            'user_id' => $authUser->id,
            'tags' => 'tag1,tag2'
        ];

        // Act
        $response = $this->actingAs($authUser)->post(route($this->storeQuestionRoute), $questionData);

        // Assert
        $response->assertStatus(302);
        $this->assertDatabaseHas('questions', [
            'title' => 'test question title',
            'body' => 'test question body',
            'user_id' => $authUser->id
        ]);
        $this->assertDatabaseCount('questions', 1);
    }

    public function test_authenticated_user_must_provide_title_for_the_question()
    {
        // Arrange
        $authUser = User::factory()->create();
        $questionData = [
            'body' => 'this is a question body',
            'user_id' => $authUser->id,
            'tags' => 'tag1,tag2'
        ];

        // Act
        $response = $this->actingAs($authUser)->post(route($this->storeQuestionRoute), $questionData);

        // Assert
        $response->assertStatus(302);
        $response->assertInvalid([
            'title' => 'The title field is required'
        ]);
        $this->assertDatabaseCount('questions', 0);
    }

    public function test_authenticated_user_must_provide_description_for_the_question()
    {
        // Arrange
        $authUser = User::factory()->create();
        $questionData = [
            'title' => 'question title',
            'body' => '',
            'user_id' => $authUser->id
        ];

        // Act
        $response = $this->actingAs($authUser)->post(route($this->storeQuestionRoute), $questionData);

        // Assert
        $response->assertStatus(302);
        $response->assertInvalid([
            'body' => 'The body field is required',
        ]);
        $this->assertDatabaseEmpty('questions');
    }

    public function test_tags_are_not_mandatory_when_create_new_question()
    {
        // Arrange
        $authUser = User::factory()->create();
        $questionData = [
            'title' => 'this is questions title',
            'body' => 'this is question description',
            'user_id' => $authUser->id
        ];

        //Assert
        $response = $this->actingAs($authUser)->post(route($this->storeQuestionRoute), $questionData);

        // Assert
        $response->assertStatus(302);
        $this->assertDatabaseHas('questions', [
            'title' => 'this is questions title',
            'body' => 'this is question description'
        ]);
        $this->assertDatabaseCount('questions', 1);
    }
}
