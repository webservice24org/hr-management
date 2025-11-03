@component('mail::message')
# Congratulations {{ $candidate->first_name }}!

You have been **shortlisted** for the position of **{{ $candidate->position->position_name ?? 'N/A' }}**.

**Interview Date:** {{ \Carbon\Carbon::parse($shortlist->interview_date)->format('d M, Y') }}

@component('mail::button', ['url' => route('candidate.success', $candidate->id)])
View Your Application
@endcomponent

We look forward to meeting you!

Thanks,<br>
{{ config('app.name') }} Recruitment Team
@endcomponent
