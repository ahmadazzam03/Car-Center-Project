@props(['bodyClass'=>'' ,'title' =>''])
<!DOCTYPE html>
{{-- This line to chang a language to suitable for local language in env file --}}
<html lang="{{str_replace('_','-',app()->getLocale())}}" >
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf_token" content="{{csrf_token()}}">
    <link rel="icon" type="image/x-icon" href="{{ asset('/image/Logoorange.png') }}">
    {{-- to display website name  --}}
    <title> {{$title}} | {{config('app.name','Laravel')}}</title>
    <!-- BOX ICONS LINK  -->
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <!-- CHART JS SCRIPT CDN LINK   -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- FontAwesome Icons Links  --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- Custom JavaScript & Css File For Project  --}}
        @vite(['resources/css/admin/dashboard.css','resources/js/admin/dashboard.js','resources/css/admin/ManageCar.css'])
    {{-- Sweet Alert2 link  --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
<body @if($bodyClass)class="{{$bodyClass}}"@endif>
    {{$slot}}
</body>
</html>
