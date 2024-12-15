<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Admin;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PodcastController
 */
final class PodcastControllerTest extends TestCase
{
    use AdditionalAssertions, WithFaker;

    #[Test]
    public function getFeatured_behaves_as_expected(): void
    {
        $response = $this->get(route('podcasts.getFeatured'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }

    #[Test]
    public function getPopular_behaves_as_expected(): void
    {
        $response = $this->get(route('podcasts.getPopular'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }

    #[Test]
    public function getDetailed_behaves_as_expected(): void
    {
        $response = $this->get(route('podcasts.getDetailed'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }

    #[Test]
    public function addToSaved_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PodcastController::class,
            'addToSaved',
            \App\Http\Requests\PodcastAddToSavedRequest::class
        );
    }

    #[Test]
    public function addToSaved_behaves_as_expected(): void
    {
        $title = $this->faker->sentence(4);
        $description = $this->faker->text();
        $image_url = $this->faker->word();
        $language = $this->faker->randomElement(/** enum_attributes **/);
        $featured = $this->faker->boolean();
        $admin = Admin::factory()->create();
        $category = Category::factory()->create();

        $response = $this->get(route('podcasts.addToSaved'), [
            'title' => $title,
            'description' => $description,
            'image_url' => $image_url,
            'language' => $language,
            'featured' => $featured,
            'admin_id' => $admin->id,
            'category_id' => $category->id,
        ]);
    }
}
