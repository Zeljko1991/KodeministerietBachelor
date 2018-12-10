<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
	    <!-- CSRF Token -->
    	<meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{config('app.name', 'Kodeministeriet')}}</title>
    </head>
    <body class="{{ Request::path() == 'login' ? 'background-image' : ''}}">
        <div id="app">
            @include('inc.navbar')
            <div class="container">
                @yield('content')
            </div>
        </div>

        <script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>

        <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
        <script>
            CKEDITOR.replace( 'article-ckeditor' );
        </script>
         @include('inc.messages')
    </body>
</html>
