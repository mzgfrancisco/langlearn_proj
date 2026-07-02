<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Language Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-800 to-sky-400 font-inter text-slate-800">

    @yield('main-content')

    @vite(['resources/js/auth.js', 'resources/js/categories.js'])
</body>
</html>
