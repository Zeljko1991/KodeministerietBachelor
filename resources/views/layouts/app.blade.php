<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
	    <!-- CSRF Token -->
    	<meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{config('app.name', 'Kodeministeriet')}}</title>
        @guest
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        @else
        @endif
    </head>
    <body >
            <div id="app">
                <v-app id="inspire">
                    @guest
                    @else
                    <v-navigation-drawer clipped fixed v-model="drawer" app>
                        <site-nav></site-nav>
                    </v-navigation-drawer>
                    @endif
                    <!--KEEP THIS-->
                        <v-content class="@guest background-image @endif">
                            <v-container fluid fill-height>
                                <v-layout>
                                    <v-flex text-xs-center>
                                    @yield('content')
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-content>
                    
                    <v-toolbar color="#3949AB" dark fixed app clipped-left>
                        @guest
                        @else
                            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
                        @endif
                            <v-toolbar-title>
                                        <v-img width="150px" src="/img/site/KMlogowhite.png"></v-img>
                            </v-toolbar-title>
                            
                            <v-spacer></v-spacer>
                        @guest
                        @else
                        <span class="group pa-2">
                            <v-menu bottom left>
                                <v-btn icon slot="activator">
                                    <v-avatar color="#3949AB">
                                        <v-icon large dark>account_circle</v-icon>
                                    </v-avatar>
                                </v-btn>
                                <v-list>
                                    <v-list-tile>
                                            <v-btn flat href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</v-btn>
                                    </v-list-tile>
                                </v-list>
                            </v-menu>
                        </span>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endif
                    </v-toolbar>
                    <v-footer color="#3949AB" app fixed clipped-left>
                        <span class="white--text" style="padding-left: 30px">Kodeministeriet&copy; 2018</span>
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
