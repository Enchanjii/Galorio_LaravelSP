@extends('components.layout')

@section('content')
    <div class="container py-5">
        <h2>Student Profile</h2>

        <div class="card mb-3">
            <div class="card-body">
                <p><strong>Name:</strong> {{ $student['name'] ?? $student->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $student['email'] ?? $student->email ?? 'N/A' }}</p>
                <p><strong>Course:</strong> {{ $student['course'] ?? $student->course ?? 'N/A' }}</p>
                <p><strong>Year Level:</strong> {{ $student['year'] ?? $student->year ?? 'N/A' }}</p>
            </div>
        </div>
        
        <a href="{{ url('/students') }}" class="btn btn-secondary">Back to Student List</a>
    </div>
@endsection
