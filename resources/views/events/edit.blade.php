<!doctype html>
<html lang="{{app()->getLocale()}}">
<head>
    <title>{{__('translations.edit_event')}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link href="{{ asset('css/menu.css') }}" rel="stylesheet">
    <link href="{{ asset('css/events/events-create.css') }}" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        @include('components.menu')

        <main class="col-md-10 col-lg-10 ms-sm-auto px-md-4">
            <h2>{{__('translations.edit_event')}}</h2>

            <div class="back-button">
                <a href="{{route('events.show',['eventId' => $event->id])}}" class="btn btn-secondary">
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

            <form method='POST' action="{{ route('events.update',['eventId' => $event->id])}}">
                @csrf
                @method('PUT')

                <div class="row event-border">
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default">{{__('translations.event_name')}}</span>
                            <input name="event_name" type="text" class="form-control"
                                   aria-label="{{__('translations.event_name')}}"
                                   aria-describedby="inputGroup-sizing-default" value="{{$event->event_name}}"
                                   required>

                            @error('event_name')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <span class="input-group-text">{{__('translations.note')}}</span>
                            <textarea name="note" class="form-control"
                                      aria-label="{{__('translations.note')}}">{{$event->note}}</textarea>
                        </div>

                        <div class="input-group">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default">{{__('translations.start_time')}}</span>
                            <input name="start_time" type="datetime-local" class="form-control"
                                   aria-label="{{__('translations.start_time')}}"
                                   aria-describedby="inputGroup-sizing-default" value="{{$event->start_time}}"
                                   required>

                            @error('start_time')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <span class="input-group-text">{{__('translations.end_time')}}</span>
                            <input name="end_time" type="datetime-local" class="form-control"
                                   aria-label="{{__('translations.end_time')}}"
                                   aria-describedby="inputGroup-sizing-default" value="{{$event->end_time}}" required>

                            @error('end_time')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="input-group price">
                            <h3 class="price-title">{{__('translations.prices')}}</h3>
                        </div>

                        <input id="cost_cost_id" type="hidden" name="cost[cost_id]"
                               value="{{$event->cost->id}}">

                        <div class="input-group">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default">{{__('translations.package')}}</span>
                            <select name="cost[package_id]" class="form-select"
                                    aria-label="{{__('translations.package')}}" required>
                                @foreach($packages as $package)
                                    <option
                                        value='{{ $package->id }}' {{ $event->cost->package->id == $package->id ? 'selected' : '' }}>
                                        {{ $package->getName() }} [ {{ __('translations.price') }}
                                        : {{ $package->getPrice() }} ]
                                    </option>
                                @endforeach
                            </select>

                            @error('cost.package_id')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default">{{__('translations.transport_price')}}</span>
                            <input name="cost[transport_price]" type="number"
                                   value="{{$event->cost->transport_price}}" step="any" class="form-control"
                                   aria-label={{__('translations.transport_price')}}
                                   aria-describedby="inputGroup-sizing-default" required>

                            @error('cost.transport_price')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default">{{__('translations.addons_price')}}</span>
                            <input name="cost[addons_price]" type="number" value="{{$event->cost->addons_price}}"
                                   step="any" class="form-control"
                                   aria-label={{__('translations.addons_price')}}
                                   aria-describedby="inputGroup-sizing-default" required>

                            @error('cost.addons_price')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default">{{__('translations.discount')}}</span>
                            <input name="cost[discount]" type="number" value="{{$event->cost->discount ?? 0}}"
                                   step="any" class="form-control"
                                   aria-label={{__('translations.discount')}}
                                   aria-describedby="inputGroup-sizing-default" required>

                            @error('cost.discount')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default">{{__('translations.deposit')}}</span>
                            <input name="cost[deposit_cost]" type="number" value="{{$event->cost->deposit_cost}}"
                                   step="any" class="form-control"
                                   aria-label={{__('translations.deposit')}}
                                   aria-describedby="inputGroup-sizing-default" disabled>

                            @error('cost.deposit_cost')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <span class="input-group-text"
                                  id="inputGroup-sizing-default">{{__('translations.total_cost')}}</span>
                            <input name="cost[total_cost]" type="number" value="{{$event->cost->total_cost}}" step="any"
                                   class="form-control"
                                   aria-label={{__('translations.total_cost')}}
                                   aria-describedby="inputGroup-sizing-default" disabled>

                            @error('cost.total_cost')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-check form-switch input-group">
                            <input class="form-check-input gmail-sync-input" name="cost[deposit_paid]" type="checkbox"
                                   role="switch" id="deposit_paid" {{$event->cost->deposit_paid ? 'checked' : ''}}>
                            <label class="form-check-label gmail-sync-label"
                                   for="deposit_paid">{{__('translations.deposit_paid')}}</label>
                        </div>

                        <div class="form-check form-switch input-group">
                            <input class="form-check-input gmail-sync-input" name="google-calendar-sync" type="checkbox"
                                   role="switch"
                                   id="google-calendar-sync" {{$event->google_calendar_event_id ? 'checked' : ''}}>
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

                        <div class="input-group">
                            <button type="submit" class="btn btn-success">{{__('translations.update')}}</button>
                        </div>
                    </div>

                    <div class="col">
                        <input id="client_delivery_address_id" type="hidden" name="client_delivery[address_id]"
                               value="{{$event->deliveryAddress->id}}">

                        <h4 class="delivery-address-title">{{__('translations.delivery_address')}}</h4>

                        <div class="input-group">
                            <input type="text" class="form-control" id="client-delivery-search"
                                   placeholder="{{__('translations.search_delivery_address')}}"
                                   aria-label="{{__('translations.search_delivery_address')}}">
                        </div>

                        <div class="input-group">
                            <select hidden id="client-delivery-results"></select>
                        </div>

                        <div class="input-group">
                            <span class="input-group-text">{{__('translations.street')}}</span>
                            <input id="client_delivery_street" name="client_delivery[street]" type="text"
                                   class="form-control" aria-label="Street" value="{{$event->deliveryAddress->street}}"
                                   required>

                            @error('delivery_address.street')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <span class="input-group-text">{{__('translations.city')}}</span>
                            <input id="client_delivery_city" name="client_delivery[city]" type="text"
                                   class="form-control" aria-label="City" value="{{$event->deliveryAddress->city}}"
                                   required>

                            @error('delivery_address.city')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <span class="input-group-text">{{__('translations.postcode')}}</span>
                            <input id="client_delivery_postcode" name="client_delivery[postcode]" type="text"
                                   class="form-control" aria-label="Postcode"
                                   value="{{$event->deliveryAddress->postcode}}" required>

                            @error('delivery_address.postcode')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <h4 class="client-address-title">{{__('translations.client')}}</h4>

                        <div class="input-group">
                            <input type="text" class="form-control" id="client-search"
                                   placeholder="{{__('translations.search_client')}}"
                                   aria-label="{{__('translations.search_client')}}">
                        </div>

                        <div class="input-group">
                            <select hidden id="client-search-results"></select>
                        </div>

                        <input id="client_client_id" type="hidden" name="client[client_id]"
                               value="{{$event->client->id}}">

                        <div class="input-group">
                            <input id="client_first_name" type="text" class="form-control" name="client[first_name]"
                                   placeholder="{{__('translations.first_name')}}"
                                   aria-label="{{__('translations.first_name')}}"
                                   value="{{$event->client->first_name}}" required>

                            @error('client.first_name')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <input id="client_last_name" type="text" class="form-control" name="client[last_name]"
                                   placeholder="{{__('translations.last_name')}}"
                                   aria-label="{{__('translations.last_name')}}" value="{{$event->client->last_name}}"
                                   required>

                            @error('client.last_name')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <input id="client_pesel" type="text" class="form-control" name="client[pesel]"
                                   placeholder="{{__('translations.pesel')}}" aria-label="{{__('translations.pesel')}}"
                                   value="{{$event->client->pesel}}">
                        </div>

                        <div class="input-group">
                            <input id="client_email" type="email" class="form-control" name="client[email]"
                                   placeholder="{{__('translations.email')}}" aria-label="{{__('translations.email')}}"
                                   value="{{$event->client->email}}" required>

                            @error('client.email')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <input id="client_phone" type="text" class="form-control" name="client[phone]"
                                   placeholder="{{__('translations.phone')}}" aria-label="{{__('translations.phone')}}"
                                   value="{{$event->client->phone}}" required>

                            @error('client.phone')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <input type="text" class="form-control" id="client-address-search"
                                   placeholder="{{__('translations.search_client_address')}}"
                                   aria-label="{{__('translations.search_delivery_address')}}">
                        </div>

                        <div class="input-group">
                            <select hidden id="client-address-results"></select>
                        </div>

                        <input id="client_address_address_id" type="hidden" name="client_address[address_id]"
                               value="{{$event->clientAddress->id}}">

                        <div class="input-group">
                            <span class="input-group-text">{{__('translations.street')}}</span>
                            <input id="client_address_street" name="client_address[street]" type="text"
                                   class="form-control" aria-label="Street" value="{{$event->clientAddress->street}}"
                                   required>

                            @error('client_address.street')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <span class="input-group-text">{{__('translations.city')}}</span>
                            <input id="client_address_city" name="client_address[city]" type="text" class="form-control"
                                   aria-label="City" value="{{$event->clientAddress->city}}" required>

                            @error('client_address.city')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="input-group">
                            <span class="input-group-text">{{__('translations.postcode')}}</span>
                            <input id="client_address_postcode" name="client_address[postcode]" type="text"
                                   class="form-control" aria-label="Postcode"
                                   value="{{$event->clientAddress->postcode}}" required>

                            @error('client_address.postcode')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>

            </form>
        </main>

    </div>
</div>


<script>
    $(document).ready(function () {
        var clientsData;
        var deliveryAddressData;
        var clientAddressData;

        $('#client-search').on('input', function () {
            var keywords = $(this).val();

            if (keywords.length >= 3) {
                $.ajax({
                    url: "{{route('clients.search-clients-by-keywords')}}",
                    method: "GET",
                    data: {keywords: keywords},
                    dataType: "json",
                    success: function (response) {
                        clientsData = response.data;

                        $('#client-search-results').empty();

                        $.each(clientsData, function (index, client) {
                            var firstOption = $('<option></option>').attr('value', '').text('Select').prop('disabled', true).prop('hidden', true).prop('selected', true);
                            $('#client-search-results').append(firstOption);

                            var option = $('<option></option>').attr('value', client.id).text(client.first_name + ' ' + client.last_name + ' | Email: ' + client.email + ' | Pesel: ' + client.pesel + ' | ' + client.phone);
                            $('#client-search-results').append(option);
                        });

                        $('#client-search-results').prop('hidden', false);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#client-search-results').empty();
                $('#client-search-results').prop('hidden', true);

                clearClientFields();
            }
        });

        $('#client-search-results').on('change', function () {
            var selectedClientId = $(this).val();
            var selectedClient = clientsData.find(client => client.id == selectedClientId);

            $('#client_client_id').val(selectedClientId);
            $('#client_first_name').val(selectedClient.first_name);
            $('#client_last_name').val(selectedClient.last_name);
            $('#client_email').val(selectedClient.email);
            $('#client_pesel').val(selectedClient.pesel);
            $('#client_phone').val(selectedClient.phone);
        });

        $('#client-search-results').prop('hidden', true);


        $('#client-delivery-search').on('input', function () {
            var keywords = $(this).val();

            if (keywords.length >= 3) {
                $.ajax({
                    url: "{{route('addresses.search-addresses-by-keywords')}}",
                    method: "GET",
                    data: {keywords: keywords},
                    dataType: "json",
                    success: function (response) {
                        deliveryAddressData = response.data;

                        $('#client-delivery-results').empty();

                        $.each(deliveryAddressData, function (index, address) {
                            var firstOption = $('<option></option>').attr('value', '').text('Select').prop('disabled', true).prop('hidden', true).prop('selected', true);
                            $('#client-delivery-results').append(firstOption);

                            var option = $('<option></option>').attr('value', address.id).text(address.street + " " + "(" + address.postcode + ")" + " " + address.city);
                            $('#client-delivery-results').append(option);
                        });

                        $('#client-delivery-results').prop('hidden', false);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#client-delivery-results').empty();
                $('#client-delivery-results').prop('hidden', true);

                clearClientDeliveryFields();
            }
        });

        $('#client-delivery-results').on('change', function () {
            var selectedDeliveryAddressId = $(this).val();
            var selectedDeliveryAddress = deliveryAddressData.find(address => address.id == selectedDeliveryAddressId);

            $('#client_delivery_street').val(selectedDeliveryAddress.street);
            $('#client_delivery_postcode').val(selectedDeliveryAddress.postcode);
            $('#client_delivery_city').val(selectedDeliveryAddress.city);
            $('#client_delivery_address_id').val(selectedDeliveryAddressId);
        });

        $('#client-delivery-results').prop('hidden', true);

        $('#delivery-address-search').on('input', function () {
            var keywords = $(this).val();

            if (keywords.length >= 3) {
                $.ajax({
                    url: "{{route('addresses.search-addresses-by-keywords')}}",
                    method: "GET",
                    data: {keywords: keywords},
                    dataType: "json",
                    success: function (response) {
                        deliveryAddressData = response.data;

                        $('#delivery-address-results').empty();

                        $.each(deliveryAddressData, function (index, address) {
                            var firstOption = $('<option></option>').attr('value', '').text('Select').prop('disabled', true).prop('hidden', true).prop('selected', true);
                            $('#delivery-address-results').append(firstOption);

                            var option = $('<option></option>').attr('value', address.id).text(address.street + " " + "(" + address.postcode + ")" + " " + address.city);
                            $('#delivery-address-results').append(option);
                        });

                        $('#delivery-address-results').prop('hidden', false);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#delivery-address-results').empty();
                $('#delivery-address-results').prop('hidden', true);

                clearClientDeliveryFields();
            }
        });

        $('#delivery-address-results').on('change', function () {
            var selectedDeliveryAddressId = $(this).val();
            var selectedDeliveryAddress = deliveryAddressData.find(address => address.id == selectedDeliveryAddressId);

            $('#client_delivery_street').val(selectedDeliveryAddress.street);
            $('#client_delivery_postcode').val(selectedDeliveryAddress.postcode);
            $('#client_delivery_city').val(selectedDeliveryAddress.city);
            $('#client_delivery_address_id').val(selectedDeliveryAddressId);
        });

        $('#delivery-address-results').prop('hidden', true);

        $('#client-address-search').on('input', function () {
            var keywords = $(this).val();

            if (keywords.length >= 3) {
                $.ajax({
                    url: "{{route('addresses.search-addresses-by-keywords')}}",
                    method: "GET",
                    data: {keywords: keywords},
                    dataType: "json",
                    success: function (response) {
                        clientAddressData = response.data;

                        $('#client-address-results').empty();

                        $.each(clientAddressData, function (index, address) {
                            var firstOption = $('<option></option>').attr('value', '').text('Select').prop('disabled', true).prop('hidden', true).prop('selected', true);
                            $('#client-address-results').append(firstOption);

                            var option = $('<option></option>').attr('value', address.id).text(address.street + " " + "(" + address.postcode + ")" + " " + address.city);
                            $('#client-address-results').append(option);
                        });

                        $('#client-address-results').prop('hidden', false);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#client-address-results').empty();
                $('#client-address-results').prop('hidden', true);

                clearClientAddressFields();
            }
        });

        $('#client-address-results').on('change', function () {
            var selectedClientAddressId = $(this).val();
            var selectedClientAddress = clientAddressData.find(address => address.id == selectedClientAddressId);

            $('#client_address_street').val(selectedClientAddress.street);
            $('#client_address_postcode').val(selectedClientAddress.postcode);
            $('#client_address_city').val(selectedClientAddress.city);
            $('#client_address_address_id').val(selectedClientAddressId);
        });

        $('#client-address-results').prop('hidden', true);
    });

    function clearClientFields() {
        $('#client_first_name').val('');
        $('#client_last_name').val('');
        $('#client_email').val('');
        $('#client_pesel').val('');
        $('#client_phone').val('');
    }

    function clearClientDeliveryFields() {
        $('#client_delivery_street').val('');
        $('#client_delivery_postcode').val('');
        $('#client_delivery_city').val('');
    }

    function clearClientAddressFields() {
        $('#client_address_street').val('');
        $('#client_address_postcode').val('');
        $('#client_address_city').val('');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const depositPaidCheckbox = document.getElementById('deposit_paid');

        depositPaidCheckbox.addEventListener('change', function () {
            depositPaidCheckbox.value = depositPaidCheckbox.checked ? 1 : 0;
        });

        const googleCalendarSyncCheckbox = document.getElementById('google-calendar-sync');

        googleCalendarSyncCheckbox.addEventListener('change', function () {
            googleCalendarSyncCheckbox.value = googleCalendarSyncCheckbox.checked ? 1 : 0;
        });

    });

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
