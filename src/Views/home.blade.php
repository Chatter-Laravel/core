@extends(config('chatter.master_file_extend'))

@section('content')
    <div id="chatter_app" class="-mt-8">
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
