@component('mail::message')
<h1>{{ __('chatter::email.greeting') }}</h1><br>
{{ __('chatter::email.preheader') }}

@component('mail::button', ['url' => route('chatter.discussion', [ 'category' => $discussion->category->slug, 'title' => $discussion->slug ])])
{{ __('chatter::email.see_discussion') }}
@endcomponent


{{ __('chatter::email.farewell') }}<br>
{{ config('app.name') }}
@endcomponent