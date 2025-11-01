<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Candidate Application</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h2, h3 { color: #2f855a; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Candidate Application Summary</h2>
    <p><strong>Application ID:</strong> {{ $candidate->candidate_apply_id }}</p>
    <p><strong>Name:</strong> {{ $candidate->first_name }} {{ $candidate->last_name }}</p>
    <p><strong>Email:</strong> {{ $candidate->email }}</p>
    <p><strong>Phone:</strong> {{ $candidate->phone }}</p>
    <p><strong>Position:</strong> {{ optional($candidate->position)->position_name }}</p>

    <h3>Education</h3>
    <table>
        <thead>
            <tr>
                <th>Degree</th>
                <th>Institution</th>
                <th>Result</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>
            @foreach($candidate->educations as $edu)
            <tr>
                <td>{{ $edu->degree }}</td>
                <td>{{ $edu->institution }}</td>
                <td>{{ $edu->result }}</td>
                <td>{{ $edu->comments }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Work Experience</h3>
    <table>
        <thead>
            <tr>
                <th>Company</th>
                <th>Working Period</th>
                <th>Duties</th>
                <th>Supervisor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($candidate->experiences as $exp)
            <tr>
                <td>{{ $exp->company_name }}</td>
                <td>{{ $exp->working_period }}</td>
                <td>{{ $exp->duties }}</td>
                <td>{{ $exp->supervisor }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top:20px;">Submitted on: {{ $candidate->created_at->format('d M Y, h:i A') }}</p>
</body>
</html>
