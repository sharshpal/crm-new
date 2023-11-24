@extends('ui.layout.master')

@section('header')
    @include('ui.partials.header')
@endsection

@section('content')

    <div class="app-body">

        @if(env("TEMPLATE_LAYOUT_MENU","sidebar")=="sidebar" && View::exists('ui.partials.sidebar'))
            @include('ui.partials.sidebar')
        @endif

        <main class="main {{ env("TEMPLATE_LAYOUT_MENU","sidebar")=="headerbar" ? "ml-0" : ""}}">

            <div class="container-fluid" id="app" :class="{'loading': loading}">
                <div class="modals">
                    <v-dialog/>
                </div>
                <div>
                    <notifications position="bottom right" :duration="2000"/>
                </div>



                @yield('body')
            </div>
        </main>
    </div>
@endsection

@section('footer')
    @include('ui.partials.footer')
@endsection

@section('bottom-scripts')
    @parent
@endsection
