<!doctype html>
<html lang="{{app()->getLocale()}}">
<head>
    <title>{{__('translations.view_event')}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link href="{{ asset('css/menu.css') }}" rel="stylesheet">
    <link href="{{ asset('css/events/events-show.css') }}" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        @include('components.menu')

        <main class="col-md-10 col-lg-10 ms-sm-auto px-md-4">
            <h2>{{ __('translations.view_event') }}</h2>

            <div class="back-button">
                <a href="{{ route('events.index') }}" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M5 12l14 0"/>
                        <path d="M5 12l6 6"/>
                        <path d="M5 12l6 -6"/>
                    </svg>
                </a>
                <a class="btn btn-primary" role="button"
                   href="{{ route('events.edit',['eventId' => $event->id]) }}">{{__('translations.edit')}}</a>
                <a href="{{route('contracts.generate-contract-for-event',['eventId' => $event->id])}}" target="_blank"
                   class="btn btn-info contract-generate">{{__('translations.contract_generate')}}</a>
                <a href="{{route('send.contract.email',['eventId' => $event->id])}}"
                   class="btn btn-dark">{{__('translations.send_contract')}}</a>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="input-group mb-2">
                        <span class="input-group-text">{{ __('translations.event_name') }}</span>
                        <input type="text" class="form-control" value="{{ $event->event_name }}" disabled>
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-text">{{ __('translations.note') }}</span>
                        <textarea class="form-control" disabled>{{ $event->note }}</textarea>
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-text">{{__('translations.delivery_address')}}</span>
                        <input type="text" class="form-control" value="{{$event->deliveryAddress->getFullAddress()}}"
                               disabled>
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-text">{{__('translations.client_address')}}</span>
                        <input type="text" class="form-control" value="{{$event->clientAddress->getFullAddress()}}"
                               disabled>
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-text">{{__('translations.phone')}}</span>
                        <input type="text" class="form-control" value="{{$event->client->phone}}" disabled>
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-text">{{__('translations.email')}}</span>
                        <input type="text" class="form-control" value="{{$event->client->email}}" disabled>
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-text">{{ __('translations.start_time') }}</span>
                        <input type="datetime-local" class="form-control" value="{{ $event->start_time }}" disabled>
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-text">{{ __('translations.end_time') }}</span>
                        <input type="datetime-local" class="form-control" value="{{ $event->end_time }}" disabled>
                    </div>

                    <div class="input-group price">
                        <h3 class="price-title">{{__('translations.prices')}}</h3>
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-text">{{ __('translations.package') }}</span>
                        <input type="text" class="form-control" value="{{ $event->cost->package->getFullName()}}"
                               disabled>
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-text">{{__('translations.transport_price')}}</span>
                        <input type="text" class="form-control" value="{{$event->cost->transport_price}}" disabled>
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-text">{{__('translations.addons_price')}}</span>
                        <input type="text" class="form-control" value="{{$event->cost->addons_price}}" disabled>
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-text">{{__('translations.discount')}}</span>
                        <input type="text" class="form-control" value="{{$event->cost->discount}}" disabled>
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-text">{{__('translations.deposit')}}</span>
                        <input type="text" class="form-control" value="{{$event->cost->deposit_cost}}" disabled>
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-text">{{__('translations.total_cost')}}</span>
                        <input type="text" class="form-control" value="{{$event->cost->total_cost}}" disabled>
                    </div>

                    <div class="input-group mb-2">
                        <input class="form-check-input gmail-sync-input" name="cost[deposit_paid]" type="checkbox"
                               role="switch" id="deposit_paid" {{$event->cost->deposit_paid ? 'checked' : ''}} disabled>
                        <label class="form-check-label gmail-sync-label"
                               for="deposit_paid">{{__('translations.deposit_paid')}}</label>
                    </div>

                    <div class="input-group mb-2">
                        <input class="form-check-input gmail-sync-input" name="google-calendar-sync" type="checkbox"
                               role="switch" id="google-calendar-sync"
                               {{$event->google_calendar_event_id ? 'checked' : ''}} disabled>
                        <label class="form-check-label gmail-sync-label"
                               for="gmail-sync">{{__('translations.gmail_sync')}}</label>
                    </div>

                    @if(session('error') || session('status'))
                        <div class="input-group mb-3">
                            @if(session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                    <br>
                                    {{ session('error_message') }}
                                </div>
                            @endif

                            @if(session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="input-group mb-2">
                        <a type="submit" class="btn btn-danger" role="button"
                           onClick="deleteEvent({{$event->id}})">{{__('translations.delete')}}</a>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="email-form">

                        <h4 class="email-title">{{ __('translations.emails') }}</h4>

                        <div class="email-table-container">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>{{ __('translations.email_subject') }}</th>
                                    <th>{{ __('translations.email_body') }}</th>
                                    <th>{{ __('translations.sent_at') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($emails as $email)
                                    <tr>
                                        <td>{{ $email->subject }}</td>
                                        <td>{{ $email->body }}</td>
                                        <td>{{ $email->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a class="page-link" href="{{ $emails->url(1) }}">{{ __('translations.first') }}</a>
                            </li>

                            @if ($emails->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">{{ __('translations.previous') }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $emails->previousPageUrl() }}"
                                       tabindex="-1">{{ __('translations.previous') }}</a>
                                </li>
                            @endif

                            @foreach ($emails->getUrlRange(1, $emails->lastPage()) as $page => $url)
                                <li class="page-item {{ $emails->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            @if ($emails->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link"
                                       href="{{ $emails->nextPageUrl() }}">{{ __('translations.next') }}</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">{{ __('translations.next') }}</span>
                                </li>
                            @endif

                            <li class="page-item">
                                <a class="page-link"
                                   href="{{ $emails->url($emails->lastPage()) }}">{{ __('translations.last') }}</a>
                            </li>
                        </ul>

                        {{--                    <h4>{{ __('translations.send_new_email') }}</h4>--}}
                        <form method="POST" action="">
                            @csrf

                            <div class="input-group mb-3">
                                <span class="input-group-text">{{ __('translations.email_subject') }}</span>
                                <input type="text" class="form-control" name="subject" required>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text">{{ __('translations.email_body') }}</span>
                                <textarea class="form-control" name="body" required></textarea>
                            </div>

                            <div class="input-group mb-3">
                                <button type="submit" class="btn btn-success">{{ __('translations.send') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<script>
    function deleteEvent(eventId) {
        let confirmation = confirm("{{__('messages.confirm_delete')}}");

        if (confirmation) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/events/" + eventId,
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
