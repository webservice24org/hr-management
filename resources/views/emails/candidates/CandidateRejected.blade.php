@component('mail::message')
# Dear {{ $candidate->first_name }} {{ $candidate->last_name }},

Thank you for applying for the **{{ $candidate->position->position_name ?? 'position' }}** role at **{{ config('app.name') }}**.

After a detailed review, we regret to inform you that you were **not selected to proceed to the interview stage** at this time.

This decision was not easy — we were truly impressed by your background and skills.

@component('mail::panel')
We encourage you to stay connected and apply for future opportunities that match your expertise.
@endcomponent

Thank you again for your interest in joining our team.  
We wish you every success in your professional journey ahead.

Best regards, </br>
{{ config('app.name') }} Recruitment Team
@endcomponent
