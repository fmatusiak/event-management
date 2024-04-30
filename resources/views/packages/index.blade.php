<!doctype html>
<html lang="{{app()->getLocale()}}">
<head>
    <title>{{__('translations.packages')}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link href="{{asset('css/menu.css')}}" rel="stylesheet">
    <link href="{{asset('css/packages/packages-index.css')}}" rel="stylesheet">
</head>
<body>

<script>
    function deletePackage(packageId) {
        let confirmation = confirm("{{__('messages.confirm_delete')}}");

        if (confirmation) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/packages/" + packageId,
                type: 'DELETE',
                success: function (response) {
                    if (response.error) {
                        alert(response.error)
                    } else {
                        window.location.reload()
                    }
                },
                error: function (xhr) {
                    alert("{{__('messages.error_delete')}}")
                }
            });
        }
    }
</script>

<div class="container-fluid">
    <div class="row">
        @include('components.menu')

        <main class="main col-md-10 ms-sm-auto col-lg-10 px-md-4">
            <h2>{{__('translations.packages')}}</h2>

            <a class="create-button btn btn-success" type="button"
               href="{{route('packages.create')}}">{{__('translations.add')}}</a>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{__('translations.name')}}</th>
                        <th scope="col">{{__('translations.rental_time')}}</th>
                        <th scope="col">{{__('translations.price')}}</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($paginator as $item)
                        <tr>
                            <th scope="row">{{ $item->id }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->rental_time }}</td>
                            <td>{{ $item->price }}</td>
                            <td>
                                {{--                                <form method="POST" action="{{ route('packages.delete',['packageId' => $item->id])}}">--}}
                                <a class="btn btn-primary" role="button"
                                   href="{{ route('packages.edit',['packageId' => $item->id]) }}">{{__('translations.edit')}}</a>
                                {{--                                    @csrf--}}
                                {{--                                    @method('DELETE')--}}
                                <a type="submit" class="btn btn-danger"
                                   role="button"
                                   onClick="deletePackage({{$item->id}})">{{__('translations.delete')}}</a>
                                {{--                                </form>--}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1) }}">{{ __('translations.first') }}</a>
                </li>

                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">{{ __('translations.previous') }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}"
                           tabindex="-1">{{ __('translations.previous') }}</a>
                    </li>
                @endif

                @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                    <li class="page-item {{ $paginator->currentPage() == $page ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}">{{ __('translations.next') }}</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">{{ __('translations.next') }}</span>
                    </li>
                @endif

                <li class="page-item">
                    <a class="page-link"
                       href="{{ $paginator->url($paginator->lastPage()) }}">{{ __('translations.last') }}</a>
                </li>
            </ul>
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>


</body>
</html>
