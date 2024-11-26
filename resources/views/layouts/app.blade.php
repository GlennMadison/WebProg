<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
        <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    </head>
    <body>
            
        @include('layouts.navigation')
        
   

        <main>
            @yield('content')
            
        
        </div> 
        
    </body>
</html>
