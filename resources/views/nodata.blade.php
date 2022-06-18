@extends('layouts.app')

@section('content')
    <style>
        .nodatacard {
            background: none;
            border : none;
        }

        .nodatatext {
            font-size: 20px;
            color: white;
        }

        .go-home {
            background: white !important;
            font-weight: 500;
            color: black !important;
        }

        .go-home:hover {
            color: rgb(27, 130, 80);
        }

        .card-title {
            color: white !important;
        }
    </style>

    <div class="d-flex align-items-center justify-content-center min" style="height: 50vh">
        <div class="card text-center mx-auto nodatacard">
            <div class="card-body">
                <h1 class="card-title">Lost your way? </h1>
                <p class="card-text nodatatext">Sorry we cant find the page you're looking for. You'll find loads to explore
                    on the home page.</p>
                    <a href="{{ url('/') }}" class="btn go-home rounde">Go Home</a>

            </div>
        </div>
    </div>
@endsection
