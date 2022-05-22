@include('layouts.app')
<div class="container">
    @foreach ($result as $r)
        <div class="card mt-5" style="margin: 0 auto; max-width: 60rem">
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3">
                            <?= '<img src="' .
                                $r->thumbnail->path .
                                '.' .
                                $r->thumbnail->extension .
                                '" class="img-fluid"
                        alt="Responsive image"/>' ?>
                        </div>
                        <div class="col-sm-9">
                            <div class="jumbotron">
                                <h1 class="display-4" style="font-family: 'Caveat', cursive;">{{ $r->name }}
                                </h1>
                                <hr class="my-4">

                                @if ($r->description == '')
                                    <p class="lead">This character has no description from marvel.</p>
                                @endif
                                <p class="lead">{{ $r->description }}</p>

                                {{-- <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3" style=" width: 10rem; margin: auto">
            <div class="card-body text-center" style="font-family: 'Caveat', cursive;font-size: 34px; margin: auto">
              Comics
            </div>
          </div>


        <div class="container mt-5">
            <div class="row">
                @if ($r->comics != '')
                    @foreach ($r->comics->items as $comic)
                        <div class="col-sm-4">
                            <?php
                            $array_url = explode('/', $comic->resourceURI);
                            $id = end($array_url);
                            $img_url = \App\Http\Controllers\MarvelComics::getComicImg($id);
                            ?>

                            @if ($img_url != null)

                            <div class="box-item ">
                                <div class="flip-box">
                                    <div class="flip-box-front text-center shadow-lg p-3 mb-5 bg-body rounded"
                                        style="background-image: url('<?= $img_url ?>');">

                                    </div>
                                    <div class="flip-box-back text-center"
                                        style="background-image: url('<?= $img_url ?>');">
                                        <div class="inner text-white">
                                            <h3 class="flip-box-header">{{ $comic->name }}</h3>
                                            {{-- <a href="{{ route('comics', $id) }}"
                                                class="btn btn-outline-primary text-white ">Learn more</a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @else
                            <p>No results</p>
                            @endif


                        </div>
                    @endforeach
                @endif

            </div>
        </div>



       



    
    @endforeach
    </body>

    </html>
