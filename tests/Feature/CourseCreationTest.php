<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Module;
use App\Models\Content;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CourseCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_can_be_created_with_nested_modules_and_contents()
    {
        Storage::fake('public');

        $video = UploadedFile::fake()->create('video.mp4', 1000, 'video/mp4');

        $data = [
            'title' => 'Test Course',
            'description' => 'Test Description',
            'category' => 'Test Category',
            'feature_video' => $video,
            'modules' => [
                [
                    'title' => 'Module 1',
                    'contents' => [
                        [
                            'title' => 'Content 1.1',
                            'type' => 'youtube',
                            'value' => 'https://youtube.com/1.1',
                            'length' => '10:00',
                        ],
                        [
                            'title' => 'Content 1.2',
                            'type' => 'vimeo',
                            'value' => 'https://vimeo.com/1.2',
                            'length' => '05:00',
                        ],
                    ],
                ],
                [
                    'title' => 'Module 2',
                    'contents' => [
                        [
                            'title' => 'Content 2.1',
                            'type' => 'file',
                            'value' => 'file.mp4',
                            'length' => '15:00',
                        ],
                    ],
                ],
            ],
        ];

        $response = $this->post(route('course.store'), $data);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('courses', [
            'title' => 'Test Course',
        ]);

        $course = Course::first();
        $this->assertCount(2, $course->modules);

        $module1 = $course->modules()->where('title', 'Module 1')->first();
        $this->assertCount(2, $module1->contents);
        $this->assertDatabaseHas('contents', [
            'module_id' => $module1->id,
            'title' => 'Content 1.1',
        ]);

        $module2 = $course->modules()->where('title', 'Module 2')->first();
        $this->assertCount(1, $module2->contents);
        $this->assertDatabaseHas('contents', [
            'module_id' => $module2->id,
            'title' => 'Content 2.1',
        ]);

        Storage::disk('public')->assertExists('videos/' . $video->hashName());
    }

    public function test_course_creation_fails_with_invalid_data()
    {
        $response = $this->post(route('course.store'), []);

        $response->assertSessionHasErrors(['title', 'description', 'feature_video']);
    }
}
