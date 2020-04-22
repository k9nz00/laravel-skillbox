<?php

namespace Tests\Feature;

use App\Models\Admin\Feedback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testUserCanCreateFeedbackMessage()
    {
        $feedbackMessage = [
            'email' => $this->faker->email,
            'feedback' => $this->faker->sentence,
        ];
        $this->post(route('message.store', $feedbackMessage, $feedbackMessage));
        $this->assertDatabaseHas('feedback', $feedbackMessage);
    }
}
