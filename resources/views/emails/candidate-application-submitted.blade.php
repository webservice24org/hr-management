<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Application Submitted</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2 style="color: #006400;">Dear {{ $candidate->first_name }} {{ $candidate->last_name }},</h2>

    <p>Thank you for applying for the position of <strong>{{ $candidate->position->position_name ?? '-' }}</strong>.</p>

    <p>Your application has been submitted successfully!</p>

    <p><strong>Application ID:</strong> {{ $candidate->candidate_apply_id }}</p>

    <p>You can download your submitted application as a PDF using the attachment, or click the link below:</p>

    <p>
        <a href="{{ route('candidate.success', $candidate->id) }}" 
           style="background-color:#28a745; color:#fff; padding:10px 15px; text-decoration:none; border-radius:5px;">
           View Application Online
        </a>
    </p>

    <br>
    <p>Best regards,<br>
    <strong>{{ config('app.name') }}</strong></p>
</body>
</html>
