<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/students', function () {
    $courseMap = Course::all(); // Get code => fullName mapping

    $students = Student::all()->map(function ($s) use ($courseMap) {
        return [
            'id' => $s->id,
            'name' => $s->name,
            'email' => $s->email,
            'course' => $courseMap[$s->course] ?? $s->course, // Display full name, fallback to code
            'year' => $s->year,
        ];
    })->toArray();

    // Sort by course first, then by name in descending order
    usort($students, function ($a, $b) {
        $courseCompare = strcmp($a['course'], $b['course']);
        if ($courseCompare !== 0) {
            return $courseCompare;
        }
        return strcmp($b['name'], $a['name']);
    });

    return view('students.index', ["samples" => $students]);
});

// Show create form
Route::get('/students/create', function () {
    $courses = Course::all();
    return view('students.create', compact('courses'));
});

// Store new student
Route::post('/students', function (Request $request) {
    $courses = Course::getList();

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'course' => 'required|in:' . implode(',', $courses),
        'year' => 'required|in:1,2,3,4,5',
    ]);

    Student::create($data);

    return redirect('/students')->with('success', 'Student added successfully.');
});

// Show student details (DB first, then static sample fallback)
Route::get('/students/{id}', function ($id) {
    $s = Student::find($id);
    if ($s) {
        $courseMap = Course::all();
        $student = [
            'id' => $s->id,
            'name' => $s->name,
            'email' => $s->email,
            'course' => $courseMap[$s->course] ?? $s->course, // Display full name, fallback to code
            'year' => $s->year,
        ];
        return view('students.show', compact('student'));
    }
});



// Edit student
Route::get('/students/{id}/edit', function ($id) {
    $s = Student::find($id);
    if ($s) {
        $student = [
            'id' => $s->id,
            'name' => $s->name,
            'email' => $s->email,
            'course' => $s->course,
            'year' => $s->year,
        ];
        $courses = Course::all();
        return view('students.edit', compact('student', 'courses'));
    }
});

// Update student
Route::post('/students/{id}', function (Request $request, $id) {
    $student = Student::find($id);
    if (!$student) {
        return redirect('/students')->with('error', 'Student not found.');
    }

    $courses = Course::getList();

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'course' => 'required|in:' . implode(',', $courses),
        'year' => 'required|in:1,2,3,4,5',
    ]);

    $student->update($data);

    return redirect('/students')->with('success', 'Student updated successfully.');
});

// Delete student
Route::post('/students/{id}/delete', function ($id) {
    $student = Student::find($id);
    if ($student) {
        $student->delete();
        return redirect('/students')->with('success', 'Student deleted successfully.');
    }
    return redirect('/students')->with('error', 'Student not found.');
});