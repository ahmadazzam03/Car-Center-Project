@props(['bodyClass'=>'' ,'title' =>''])
<!DOCTYPE html>
{{-- This line to chang a language to suitable for local language in env file --}}
<html lang="{{str_replace('_','-',app()->getLocale())}}" >
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf_token" content="{{csrf_token()}}">
    {{-- to display website name  --}}
    <title> {{$title}} | {{config('app.name','Laravel')}}</title>
        {{--  Add the Favicon to Your HTML --}}
        <link rel="icon" type="image/x-icon" href="{{ asset('/image/Logoorange.png') }}">
        {{-- Google Fonts (Ubuntu Font) --}}
            <link rel="preconnect" href="https://fonts.googleapis.com" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
            <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet"/>
        {{-- FontAwesome Icons Links  --}}
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        {{-- Box icons --}}
            <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        {{-- Custom JavaScript & Css File For Project  --}}
            @vite(['resources/css/app.css','resources/css/header.css','resources/js/app.js'])
            
        {{-- Sweet Alert2 link  --}}
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
<body @if($bodyClass)class="{{$bodyClass}}"@endif>
    {{$slot}}
    {{-- ScrollReveal.js Laibrary --}}
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/scrollReveal.js/4.0.9/scrollreveal.js"
            integrity="sha512-XJgPMFq31Ren4pKVQgeD+0JTDzn0IwS1802sc+QTZckE6rny7AN2HLReq6Yamwpd2hFe5nJJGZLvPStWFv5Kww=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer">
        </script>
</body>
</html>
