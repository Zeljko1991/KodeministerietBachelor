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
    <body class="@guest background-image @endif">
            <div id="app">
                <v-app id="inspire">
                    <v-navigation-drawer clipped fixed v-model="drawer" app>
                        <site-nav></site-nav>
                    </v-navigation-drawer>
                        <!--KEEP THIS-->
                        <v-content>
                            <v-container fluid fill-height>
                                <v-layout>
                                    <v-flex text-xs-center>
                                    @yield('content')
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-content>
                    
                    <v-toolbar color="indigo" dark fixed app clipped-left>
                            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
                            <v-toolbar-title>Kodeministeriet</v-toolbar-title>
                    </v-toolbar>
                    <v-footer color="indigo" app inset>
                        <span class="white--text">Kodeministeriet&copy; 2017</span>
                    </v-footer>
                </v-app>
            </div>
        <script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>

        <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
        <script>
            CKEDITOR.replace( 'article-ckeditor' );
            CKEDITOR.replace( 'deliverables' );
        </script>
         @include('inc.messages')
    </body>
</html>
