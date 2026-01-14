<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Employee Performance Review</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #f3f4f6;
        }

        .letterhead {
            border-bottom: 3px solid #003366;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .company-logo {
            width: 90px;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #003366;
        }

        .company-info {
            font-size: 11px;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 15px 0;
            text-transform: uppercase;
        }

        .section {
            margin-top: 20px;
            font-weight: bold;
        }

        .photo img {
            border-radius: 5px;
            border: 2px solid #003366;
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .signature-box {
            margin-top: 40px;
        }

        .signature {
            width: 32%;
            text-align: center;
            display: inline-block;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 50px;
            padding-top: 5px;
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>

{{-- ===================== LETTERHEAD ===================== --}}
<div class="letterhead">
    <table style="border:none">
        <tr>
            <td style="border:none;width:100px">
                <img src="{{ public_path('images/company-logo.png') }}"
                     class="company-logo"
                     alt="Company Logo">
            </td>
            <td style="border:none">
                <div class="company-name">Your Company Name Ltd.</div>
                <div class="company-info">
                    Corporate Office: 123 Business Street, Dhaka<br>
                    Phone: +880-1234-567890 | Email: hr@company.com<br>
                    Website: www.company.com
                </div>
            </td>
        </tr>
    </table>
</div>

{{-- ===================== EMPLOYEE HEADER ===================== --}}
<table style="border:none">
    <tr>
        <td style="border:none;width:120px">
            @php
                $photoPath = public_path('storage/' . $employee->candidate->picture);
                $defaultPhoto = public_path('images/default-avatar.png');
                $photoToShow = file_exists($photoPath) ? $photoPath : $defaultPhoto;
            @endphp

            <div class="photo">
                <img src="{{ $photoToShow }}" alt="Employee Photo">
            </div>
        </td>
        <td style="border:none">
            <strong>Name:</strong> {{ $employee->candidate->first_name }} {{ $employee->candidate->last_name }}<br>
            <strong>Mobile:</strong> {{ $employee->candidate->phone }}<br>
            <strong>Department:</strong> {{ $employee->information->department->department_name ?? '-' }}<br>
            <strong>Position:</strong> {{ $employee->candidate->position->position_name ?? '-' }}<br>
            <strong>Review Period:</strong> {{ $performance->review_period ?? '-' }}
        </td>
    </tr>
</table>

<div class="title">Employee Performance Review</div>

{{-- ===================== SECTION A ===================== --}}
<div class="section">A. Job Performance Assessment</div>
<table>
    <tr>
        <th>Criteria</th>
        <th>Rating</th>
        <th>Score</th>
        <th>Comments</th>
    </tr>
    @foreach($performance->section_a as $row)
        <tr>
            <td>{{ $row['label'] }}</td>
            <td>{{ $row['rating'] }}</td>
            <td>{{ $row['score'] }}</td>
            <td>{{ $row['comments'] }}</td>
        </tr>
    @endforeach
</table>

{{-- ===================== SECTION B ===================== --}}
<div class="section">B. Other Performance Standards</div>
<table>
    <tr>
        <th>Criteria</th>
        <th>Rating</th>
        <th>Score</th>
        <th>Comments</th>
    </tr>
    @foreach($performance->section_b as $row)
        <tr>
            <td>{{ $row['label'] }}</td>
            <td>{{ $row['rating'] }}</td>
            <td>{{ $row['score'] }}</td>
            <td>{{ $row['comments'] }}</td>
        </tr>
    @endforeach
</table>

{{-- ===================== SUMMARY ===================== --}}
<table style="margin-top:15px">
    <tr>
        <th>Total Score</th>
        <td>{{ $performance->total_score }}</td>
    </tr>
    <tr>
        <th>Final Rating</th>
        <td>{{ $performance->final_rating }}</td>
    </tr>
    <tr>
        <th>Overall Comment</th>
        <td>{{ $performance->overall_comment }}</td>
    </tr>
</table>

{{-- ===================== SIGNATURE SECTION ===================== --}}
<div class="signature-box">
    <div class="signature">
        <div class="signature-line">Employee Signature</div>
        Date: __________
    </div>

    <div class="signature">
        <div class="signature-line">Reviewer / Supervisor</div>
        Date: __________
    </div>

    <div class="signature">
        <div class="signature-line">HR / Management</div>
        Date: __________
    </div>
</div>

{{-- ===================== FOOTER ===================== --}}
<div class="footer">
    This document is system generated and valid without signature.
</div>

</body>
</html>
