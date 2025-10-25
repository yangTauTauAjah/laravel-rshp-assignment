<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RSHP - Rumah Sakit Hewan Pendidikan Universitas Airlangga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'rshp-blue': '#1e40af',
                        'rshp-yellow': '#fbbf24',
                        'rshp-orange': '#f59e0b',
                        'rshp-green': '#10b981',
                        'rshp-light-yellow': '#fef3c7',
                        'rshp-light-blue': '#3b82f6',
                        'rshp-light-green': '#d1fae5',
                        'rshp-dark-gray': '#374151',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .stylized-font {
            font-family: 'Arial Black', sans-serif;
        }
    </style>
</head>

<?php
session_start();
?>
<body class="bg-white flex flex-col h-screen">
    
    @include('components.nav')
    @include('components.flash_message')
      @yield('content')
    @include('components.footer')

</body>

</html>