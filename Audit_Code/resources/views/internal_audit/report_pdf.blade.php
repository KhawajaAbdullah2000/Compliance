<!DOCTYPE html>
<html>
<head>
    <title>Audit Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }
        h1, h2, h3 {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            margin-top: 20px;
        }
        .table thead th {
            background-color: #f8f9fa;
        }
        .report-header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="report-header">
        @if($level_num==1)
        <h1>Internal Audit Report</h1>
        @elseif($level_num==2)
          <h1>Risk Based Audit Plan Report</h1>
          @endif

    </div>

    <div class="mb-4">
        <h2>Organization: <span class="text-primary">{{ $organization->name }}</span></h2>
        <h2>Sub Organization: <span class="text-primary">{{ $department->name }}</span></h2>
        <h3>Project: <span class="text-primary">{{ $project->project_name }}</span></h3>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $data)
                <tr>
                    <td><strong>{{ $data['label'] }}</strong></td>
                    <td>{{ $data['value'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
