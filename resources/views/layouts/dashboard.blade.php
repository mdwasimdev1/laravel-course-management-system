<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Course</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #1f2937;
        }
        ::-webkit-scrollbar-thumb {
            background: #4b5563;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-white  antialiased">
    
    <div class="antialiased bg-white ">
        @include('layouts.partials.navbar')
        @include('layouts.partials.sidebar')

        <main class="p-4 md:ml-64 h-auto pt-20">
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                    <span class="font-medium">Success!</span> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                    <span class="font-medium">Error!</span> {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
