@extends('ui.layout.app')

@section('body')

    <div class="welcome-quote">

        @if(!empty($inspiration))
        <blockquote>
            {{ explode(" - ", $inspiration)[0] }}
            <cite>
                {{ explode(" - ", $inspiration)[1] }}
            </cite>
        </blockquote>
            @endif

    </div>

@endsection
