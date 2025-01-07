<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Progress</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="body-inventory">
    @include('layouts.navigation')

    <div class="container-inventory">
        <div class="header-section">
            <h1 class="page-title">Employee Progress</h1>
        </div>

        <div class="employee-list">
            @isset($employees)
                @if($employees->count() > 0)
                    @foreach($employees as $employee)
                        <div class="employee-card">
                            <p>Employee ID: {{ $employee->employee_id }}</p>
                            <p>Name: {{ $employee->proper_name }}</p>
                            <p>Username: {{ $employee->username }}</p>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">No employees found</div>
                @endif
            @else
                <div class="empty-state">No data available</div>
            @endisset
        </div>
    </div>

    <style>
        .body-inventory {
            background-color: #f3f4f6;
            min-height: 100vh;
        }
        .container-inventory {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .header-section {
            margin-bottom: 20px;
        }
        .page-title {
            font-size: 24px;
            font-weight: bold;
        }
        .employee-list {
            display: grid;
            gap: 20px;
        }
        .employee-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .empty-state {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 8px;
            color: #666;
        }
    </style>
</body>
</html>