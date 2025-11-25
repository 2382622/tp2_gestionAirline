@extends('layouts.app')

@section('content')
    <div id="app"></div>
@endsection

@push('scripts')
    <script>
        window.RECAPTCHA_SITE_KEY = "{{ env('RECAPTCHA_SITE_KEY', '') }}";
    </script>
    <script src="https://www.google.com/recaptcha/api.js?render=explicit" async defer></script>
    <script src="{{ mix('js/app.js') }}"></script>
@endpush

