<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function create()
    {
        return view('course-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'category' => 'nullable|string|max:255',
            'feature_video' => 'required|file|mimes:mp4,mov,avi,wmv|max:51200',
            'modules' => 'nullable|array',
            'modules.*.title' => 'required|string|max:255',
            'modules.*.contents' => 'nullable|array',
            'modules.*.contents.*.title' => 'required|string|max:255',
            'modules.*.contents.*.type' => 'required|string|in:youtube,vimeo,file',
            'modules.*.contents.*.value' => 'nullable|string',
            'modules.*.contents.*.length' => 'nullable|string',
        ], [
            'feature_video.required' => 'Please select a feature video.',
            'feature_video.file' => 'The feature video failed to upload. Check your server limits.',
            'feature_video.mimes' => 'The feature video must be a file of type: mp4, mov, avi, wmv.',
            'feature_video.max' => 'The feature video may not be greater than 50MB.',
        ]);

        DB::beginTransaction();

        try {

            $videoPath = null;

            if ($request->hasFile('feature_video')) {
                $videoPath = $request->file('feature_video')->store('videos', 'public');
            }


            $course = Course::create([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'feature_video' => $videoPath,
            ]);

            if ($request->has('modules')) {

                foreach ($request->modules as $moduleData) {

                    $module = Module::create([
                        'course_id' => $course->id,
                        'title' => $moduleData['title'],
                    ]);

                    if (isset($moduleData['contents']) && is_array($moduleData['contents'])) {

                        foreach ($moduleData['contents'] as $contentData) {

                            Content::create([
                                'module_id' => $module->id,
                                'title' => $contentData['title'],
                                'type' => $contentData['type'],
                                'value' => $contentData['value'],
                                'length' => $contentData['length'] ?? null,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Course created successfully!');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
