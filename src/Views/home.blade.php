@extends(config('chatter.master_file_extend'))

<script>
    window.default_chatter_locale = "{{ config('app.locale') }}";
    window.fallback_chatter_locale = "{{ config('app.fallback_locale') }}";
    window.chatter_messages = @json($chatterMessages);
</script>
@section('content')
    <div id="chatter_app">
        <app 
            app-name="{{ config('app.name') }}"
            :page="{{ request('page', 1) }}"
            :menu='@json($menu)'
            :categories='@json($categories)'
            :logged=@json($logged)
            :has-username=@json($hasUsername)
        ></app>
    </div>
@endsection
