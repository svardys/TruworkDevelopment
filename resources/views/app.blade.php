<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Masivní dřevo, špičková řemeslná práce a individuální přístup je to,co dělá kuchyně Truwok naprosto výjimečnými. Zakázková výroba na míru. Kuchyně, vestavěné skříně, vybavení komerčních prostor."></meta>
    <title>{{ config('app.name', 'Truwork') }}</title>
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
    <link rel="icon" href="/storage/images/initialize/logo-icon.png">
</head>
<body>
<div id="app">
    <app></app>
</div>
<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>
</html>
