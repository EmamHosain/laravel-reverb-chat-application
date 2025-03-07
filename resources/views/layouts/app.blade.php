<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none;
        }

        .tiblock {
            align-items: center;
            display: flex;
            height: 17px;
        }

        .ticontainer .tidot {
            background-color: #90949c;
        }

        .tidot {
            -webkit-animation: mercuryTypingAnimation 1.5s infinite ease-in-out;
            border-radius: 50%;
            display: inline-block;
            height: 8px;
            margin-right: 4px;
            width: 8px;
        }

        @-webkit-keyframes mercuryTypingAnimation {
            0% {
                -webkit-transform: translateY(0px)
            }

            28% {
                -webkit-transform: translateY(-5px)
            }

            44% {
                -webkit-transform: translateY(0px)
            }
        }

        .tidot:nth-child(1) {
            -webkit-animation-delay: 200ms;
        }

        .tidot:nth-child(2) {
            -webkit-animation-delay: 300ms;
        }

        .tidot:nth-child(3) {
            -webkit-animation-delay: 400ms;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <livewire:layout.navigation />

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

</body>

</html>
