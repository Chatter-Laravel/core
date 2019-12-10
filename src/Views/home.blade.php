@extends(config('chatter.master_file_extend'))

@section('content')
    <script>window.auth=@json(\Auth::check())</script>

    <div id="chatter_app">
        <app 
            app-name="{{ config('app.name') }}"
            :page="{{ request('page', 1) }}"
            :menu='@json($menu)'
            :categories='@json($categories)'
        ></app>
    </div>
@endsection
