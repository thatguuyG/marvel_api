@extends('layouts.app')

@section('content')

    <style>


    </style>


    @if ($total == 0)
        <p>No results</p>
    @else
        <div class="container mt-4">
            <div class="row">
                @foreach ($result as $r)
                    <div class="col-sm-3">
                        <div class="box-item ">
                            <div class="flip-box">
                                <div class="flip-box-front text-center shadow-lg p-3 mb-5 bg-body rounded"
                                    style="background-image: url('<?= $r->thumbnail->path . '.' . $r->thumbnail->extension ?>');">

                                </div>
                                <div class="flip-box-back text-center"
                                    style="background-image: url('<?= $r->thumbnail->path . '.' . $r->thumbnail->extension ?>');">
                                    <div class="inner text-white">
                                        <h3 class="flip-box-header">{{ $r->name }}</h3>
                                        <a href="{{ route('character', $r->id) }}"
                                            class="btn btn-outline-primary text-white ">Learn more</a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row-space"></div>
                    </div>
                @endforeach
            </div>

        </div>
        <div class="buttons">
            @if ($offset != 0)
                <a href="{{ route('index', $offset - 20) }}" class="btn btn-light">Previous</a>
            @else
                <a href="{{ route('index', $offset - 20) }}" class=""></a>
            @endif

            @if ($total >= $offset + 20)
                <a href="{{ route('index', $offset + 20) }}" class="btn btn-light">Next</a>
            @endif
        </div>
    @endif
@endsection
