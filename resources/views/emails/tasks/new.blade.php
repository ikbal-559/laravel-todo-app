@component('mail::message')
    <h3>Hi {{ $user->name }}, A new task has been assigned to you.</h3>
    <h3>{{ $task->title }}</h3>
    @component('mail::button', ['url' => route('tasks.show', $task->id)])
        View Details
    @endcomponent

    Thanks,
    {{ config('app.name') }}
@endcomponent
