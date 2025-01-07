<!DOCTYPE html>
<html>
<head>
    <title>Workshop - Weight Recording</title>
    @vite(['resources/css/app.css', 'resources/css/material_usage/weight_recording.css', 'resources/js/app.js'])

    <style>
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.25rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body class="bg-[#f3f4f6]">
    @include('layouts.navigation')
    
    <div class="breadcrumb">
        MATERIAL USAGE → Weight Recording
    </div>

    <div class="form-container">
        <h2 class="form-title">Weight Recording Form</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('material_usage.weight_recording.store') }}" method="POST">
            @csrf
            
            <div class="form-grid">
                <div class="form-column">
                    <div class="form-group">
                        <label for="employee">Employee</label>
                        <select id="employee" name="employee" class="form-control" required>
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->username }}" {{ old('employee') == $employee->username ? 'selected' : '' }}>
                                    {{ $employee->proper_name }}
                                </option>
                            @endforeach
                        </select>
                        @if(isset($error))
                            <div class="text-red-500 text-sm mt-1">{{ $error }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="material">Material ID</label>
                        <select id="material" name="material_id" class="form-control" required>
                            <option value="">Select Material ID</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->material_id }}" {{ old('material_id') == $material->material_id ? 'selected' : '' }}>
                                    {{ $material->material_id }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="task">Task ID</label>
                        <select id="task" name="task_id" class="form-control" required>
                            <option value="">Select Task ID</option>
                            @foreach($jobs as $job)
                                <option value="{{ $job->id }}" {{ old('task_id') == $job->id ? 'selected' : '' }}>
                                    {{ $job->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="stage">Stage</label>
                        <select id="stage" name="stage" class="form-control" required>
                            <option value="">Select Stage</option>
                            <option value="melting" {{ old('stage') == 'melting' ? 'selected' : '' }}>Melting</option>
                            <option value="milling" {{ old('stage') == 'milling' ? 'selected' : '' }}>Milling</option>
                            <option value="pulling" {{ old('stage') == 'pulling' ? 'selected' : '' }}>Pulling</option>
                            <option value="filing" {{ old('stage') == 'filing' ? 'selected' : '' }}>Filing</option>
                            <option value="sanding" {{ old('stage') == 'sanding' ? 'selected' : '' }}>Sanding</option>
                            <option value="polishing" {{ old('stage') == 'polishing' ? 'selected' : '' }}>Polishing</option>
                            <option value="setting" {{ old('stage') == 'setting' ? 'selected' : '' }}>Setting</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Date and Time</label>
                        <input type="datetime-local" name="date_time" class="form-control" required value="{{ old('date_time') }}">
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label for="current_weight">Current Weight</label>
                        <div class="input-group">
                            <input type="number" 
                                   id="current_weight" 
                                   name="current_weight" 
                                   class="form-control weight-input" 
                                   required 
                                   min="0" 
                                   step="0.01"
                                   value="{{ old('current_weight') }}">
                            <span class="input-group-append">g</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="notes" class="form-control notes-input">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="button-group">
                <button type="button" class="btn btn-cancel">Cancel</button>
                <button type="submit" class="btn btn-save">Save Changes</button>
            </div>
        </form>
    </div>

    <script>
        document.querySelector('.btn-cancel').addEventListener('click', function() {
        window.location.href = "{{ route('home') }}";
    });
    </script>
</body>
</html>