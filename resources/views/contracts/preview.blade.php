<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Preview</title>
</head>
<body>
@if (isset($error))
    <div>{{ $error }}</div>
@else
    <h1>Preview for Event: {{ $event->event_name }}</h1>
    <iframe src="{{ $pdf}}" width="100%" height="600px"></iframe>

@endif
</body>
</html>

