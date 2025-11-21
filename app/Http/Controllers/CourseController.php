<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {

        $courses = Course::latest()->get();
        return view('course', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        Course::create($validated);
        return redirect()->back()->with('success', 'Course added successfully!');
    }


    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);


        $course->update($validated);
        return redirect()->back()->with('success', 'Course updated successfully!');
    }


    public function destroy(Course $course) 
    {
        $course->delete();
        return redirect()->back()->with('success', 'Course deleted successfully!');
    }
}