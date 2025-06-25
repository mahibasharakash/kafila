@php
    $enJson = file_get_contents(resource_path('language/en.json'));
    $enJson = json_decode($enJson, true);
    $arJson = file_get_contents(resource_path('language/ar.json'));
    $arJson = json_decode($arJson, true);
@endphp

    <!doctype html>
<html lang="en" dir="ltr">
<head>
    <title> Kafila </title>
    @include('components.meta')
    @vite('resources/css/app.css')
    @vite('resources/js/app/visitor/app.js')
</head>
<body>
<div id="preloader" class="fixed inset-0 w-full h-screen flex justify-center items-center bg-white z-50">
    <div class="flex justify-center items-center flex-col animate-pulse">
        <div class="bg-rose-400 h-[45px] w-[100px]" style="clip-path: polygon(50% 0, 0 100%, 100% 100%)"></div>
        <div class="bg-gray-400 h-[45px] w-[70px] flex justify-center items-end rounded-b-md -mt-2">
            <div class="bg-rose-400 w-[25px] h-[20px] rounded-t-full"></div>
        </div>
        <div class="w-[100px] h-[20px]"
             style="clip-path: polygon(20% 0%, 80% 0%, 100% 100%, 0% 100%); background: linear-gradient(to bottom, rgba(209, 213, 219, 1) 0%, rgba(209, 213, 219, 0) 100%);"></div>
    </div>
</div>
<div id="app" class="hidden"></div>
@include('components.script')
</body>
</html>
