@extends('components.layout')

@section('content')
    <div class="container py-5">
        <h2>Add New Student</h2>

        <form method="POST" action="{{ url('/students') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input name="email" type="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Course</label>
                
                <!-- Search Input -->
                <input type="text" id="courseSearch" class="form-control mb-2 text-start" placeholder="Search courses..." autocomplete="off" style="text-align: left;">
                
                <!-- Hidden select (stores actual value) -->
                <select name="course" id="courseSelect" class="form-control" required style="display: none;">
                    <option value="">-- Select a Course --</option>
                    @foreach ($courses as $code => $fullName)
                        <option value="{{ $code }}" data-fullname="{{ $fullName }}" @if (old('course') === $code) selected @endif>
                            {{ $fullName }}
                        </option>
                    @endforeach
                </select>
                
                <!-- Dropdown list to display filtered options -->
                <div id="courseDropdown" class="border rounded mt-1" style="display: none; max-height: 300px; overflow-y: auto; background: white;">
                    <div id="courseOptions"></div>
                </div>
                
                @error('course')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <script>
                const searchInput = document.getElementById('courseSearch');
                const select = document.getElementById('courseSelect');
                const dropdown = document.getElementById('courseDropdown');
                const optionsContainer = document.getElementById('courseOptions');
                const allOptions = Array.from(select.querySelectorAll('option')).filter(opt => opt.value);

                // Show dropdown when clicking search input
                searchInput.addEventListener('focus', showDropdown);
                
                // Filter courses as user types
                searchInput.addEventListener('input', filterCourses);
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.mb-3')) {
                        dropdown.style.display = 'none';
                    }
                });
                function showDropdown() {
                    filterCourses();
                    dropdown.style.display = 'block';
                }
                function filterCourses() {
                    const searchTerm = searchInput.value.toLowerCase();
                    optionsContainer.innerHTML = '';
                    const filtered = allOptions.filter(option => 
                        option.textContent.toLowerCase().includes(searchTerm)
                    );
                    if (filtered.length === 0) {
                        optionsContainer.innerHTML = '<div class="p-2 text-muted">No courses found</div>';
                        return;
                    }
                    filtered.forEach(option => {
                        const div = document.createElement('div');
                        div.className = 'p-2';
                        div.style.cursor = 'pointer';
                        div.textContent = option.textContent;
                        div.setAttribute('data-value', option.value);
                        // Highlight when hovered
                        div.addEventListener('mouseover', function() {
                            this.style.backgroundColor = '#f0f0f0';
                        });
                        div.addEventListener('mouseout', function() {
                            this.style.backgroundColor = 'transparent';
                        });
                        // Select when clicked
                        div.addEventListener('click', function() {
                            searchInput.value = option.textContent;
                            select.value = option.value;
                            dropdown.style.display = 'none';
                        });
                        optionsContainer.appendChild(div);
                    });
                }
            </script>

            <div class="mb-3">
                <label class="form-label">Year Level</label>
                <select name="year" class="form-control" required>
                    <option value="">-- Select Year Level --</option>
                    <option value="1" @if (old('year') === '1') selected @endif>1st Year</option>
                    <option value="2" @if (old('year') === '2') selected @endif>2nd Year</option>
                    <option value="3" @if (old('year') === '3') selected @endif>3rd Year</option>
                    <option value="4" @if (old('year') === '4') selected @endif>4th Year</option>
                    <option value="5" @if (old('year') === '5') selected @endif>5th Year</option>
                </select>
                @error('year')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Add Student</button>
                <a href="{{ url('/students') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection