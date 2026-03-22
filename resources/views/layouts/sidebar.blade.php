<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AtlasBulletinBoard</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&family=Oswald:wght@200&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/7762b90c64.js" crossorigin="anonymous"></script>
</head>

<body class="all_content">
    <div class="d-flex">
        <div class="sidebar">
            <p><a href="{{ route('top.show') }}"><i class="fa-regular fa-house" style="color: rgb(255, 255, 255);"></i> トップ</a></p>
            <p><a href="/logout"><i class="fa-solid fa-arrow-right-from-bracket" style="color: rgb(255, 255, 255);"></i> ログアウト</a></p>
            <p><a href="{{ route('calendar.general.show', ['user_id' => Auth::id()]) }}"><i class="fa-regular fa-calendar-days" style="color: rgb(255, 255, 255);"></i> スクール予約</a></p>
            @can('admin')
            <p><a href="{{ route('calendar.admin.show', ['user_id' => Auth::id()]) }}"><i class="fa-regular fa-calendar-check" style="color: rgb(255, 255, 255);"></i> スクール予約確認</a></p>
            <p><a href="{{ route('calendar.admin.setting', ['user_id' => Auth::id()]) }}"><i class="fa-regular fa-calendar-plus" style="color: rgb(255, 255, 255);"></i> スクール枠登録</a></p>
            @endcan
            <p><a href="{{ route('post.show') }}"><i class="fa-solid fa-comment-dots" style="color: rgb(255, 255, 255);"></i> 掲示板</a></p>
            <p><a href="{{ route('user.show') }}"><i class="fa-solid fa-user-group" style="color: rgb(255, 255, 255);"></i> ユーザー検索</a></p>
        </div>
        <div class="main-container">
            {{ $slot }}
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/bulletin.js') }}" rel="stylesheet"></script>
    <script src="{{ asset('js/user_search.js') }}" rel="stylesheet"></script>
    <script src="{{ asset('js/calendar.js') }}" rel="stylesheet"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>

</html>
