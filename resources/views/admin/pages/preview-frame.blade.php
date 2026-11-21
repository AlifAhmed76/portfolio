<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preview: {{ $page->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #070a12;
            color: #f8fafc;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div class="preview-container">
        <x-blocks.renderer :blocks="$blocks" />
    </div>
</body>
</html>
