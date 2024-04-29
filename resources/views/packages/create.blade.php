<!doctype html>
<html lang="{{app()->getLocale()}}">
<head>
    <title>{{__('translations.create_new_package')}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ asset('css/menu.css') }}" rel="stylesheet">
    <link href="{{ asset('css/packages/packages-create.css') }}" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        @include('components.menu')

        <main class="col-md-10 col-lg-10 ms-sm-auto px-md-4">
            <h2>{{__('translations.create_new_package')}}</h2>

            <div class="back-button">
                <a href="{{route('packages.index')}}" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M5 12l14 0"/>
                        <path d="M5 12l6 6"/>
                        <path d="M5 12l6 -6"/>
                    </svg>
                </a>
            </div>

            <form method='POST' action="{{ route('packages.store') }}">
                @csrf
                @method('POST')

                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">{{__('translations.name')}}</span>
                    <input name="name" type="text" class="form-control"
                           aria-label="Sizing example input"
                           aria-describedby="inputGroup-sizing-default" required>

                    @error('name')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror

                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text"
                          id="inputGroup-sizing-default">{{__('translations.rental_time')}}</span>
                    <input name="rental_time" type="number" class="form-control"
                           aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>

                    @error('rental_time')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror

                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">{{__('translations.price')}}</span>
                    <input name="price" type="number" step="any" class="form-control"
                           aria-label="Sizing example input"
                           aria-describedby="inputGroup-sizing-default" required>

                    @error('price')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror

                </div>

                @if(session('error') || session('exception_message') || session('status'))
                    <div class="input-group mb-3">
                        @if(session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('exception_message'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('exception_message') }}
                            </div>
                        @endif

                        @if(session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                @endif

                <div class="input-group mb-3">
                    <button type="submit" class="btn btn-success">{{__('translations.create')}}</button>
                </div>

            </form>
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
