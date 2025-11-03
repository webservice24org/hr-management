<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $candidate->first_name }} {{ $candidate->last_name }} - CV</title>
    <style>
        body {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
            background: #fff;
        }
        h1, h2, h3, h4 {
            margin: 0;
            padding: 0;
        }
        .title-bar {
            background-color: #003366;
            color: #fff;
            padding: 10px;
            margin-bottom: 15px;
            text-transform: uppercase;
            font-size: 13px;
        }
        .header {
            border-bottom: 2px solid #003366;
            margin-bottom: 15px;
            padding-bottom: 5px;
        }
        .header h1 {
            color: #003366;
            font-size: 20px;
        }
        .header h3 {
            font-size: 12px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            padding: 6px 8px;
            vertical-align: top;
        }
        th {
            background-color: #f1f5f9;
            color: #003366;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ccc;
        }
        td {
            border: 1px solid #e5e7eb;
        }
        .photo {
            text-align: right;
        }
        .photo img {
            border-radius: 5px;
            border: 2px solid #003366;
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            color: #777;
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    <div class="header">
        <table width="100%">
            <tr>
                <td>
                    <h1>{{ $candidate->first_name }} {{ $candidate->last_name }}</h1>
                    <h3>Application ID: {{ $candidate->candidate_apply_id }}</h3>
                    <p><strong>Applied for:</strong> {{ $candidate->position->position_name ?? '-' }}</p>
                </td>
                <td class="photo">
                    @php
                        $photoPath = public_path('storage/' . $candidate->picture);
                        $defaultPhoto = public_path('images/default-avatar.png');
                        $photoToShow = file_exists($photoPath) ? $photoPath : $defaultPhoto;
                    @endphp

                    <img src="{{ $photoToShow }}" alt="Candidate Photo">
                </td>

            </tr>
        </table>
    </div>

    <div class="title-bar">Personal Information</div>
    <table>
        <tr><th>Email</th><td>{{ $candidate->email }}</td></tr>
        <tr><th>Phone</th><td>{{ $candidate->phone }}</td></tr>
        <tr><th>Alternative Phone</th><td>{{ $candidate->alternative_phone ?? '-' }}</td></tr>
        <tr><th>Present Address</th><td>{{ $candidate->present_address }}</td></tr>
        <tr><th>Permanent Address</th><td>{{ $candidate->permanent_address }}</td></tr>
        <tr><th>City</th><td>{{ $candidate->city }}</td></tr>
        <tr><th>Division</th><td>{{ $candidate->division }}</td></tr>
        <tr><th>Post Code</th><td>{{ $candidate->post_code }}</td></tr>
    </table>

    <div class="title-bar">Education</div>
    <table>
        <tr>
            <th>Degree</th>
            <th>Institution</th>
            <th>Result</th>
            <th>Comments</th>
        </tr>
        @foreach($candidate->educations as $edu)
            <tr>
                <td>{{ $edu->degree }}</td>
                <td>{{ $edu->institution }}</td>
                <td>{{ $edu->result }}</td>
                <td>{{ $edu->comments ?? '-' }}</td>
            </tr>
        @endforeach
    </table>

    <div class="title-bar">Work Experience</div>
    <table>
        <tr>
            <th>Company</th>
            <th>Working Period</th>
            <th>Duties</th>
            <th>Supervisor</th>
        </tr>
        @forelse($candidate->experiences as $exp)
            <tr>
                <td>{{ $exp->company_name }}</td>
                <td>{{ $exp->working_period }}</td>
                <td>{{ $exp->duties }}</td>
                <td>{{ $exp->supervisor }}</td>
            </tr>
        @empty
            <tr><td colspan="4" style="text-align:center; color:#777;">No experience added</td></tr>
        @endforelse
    </table>

    <div class="footer">
        Generated on {{ now()->format('d M, Y') }} — Powered by Progressive-cht.org
    </div>

</body>
</html>
