<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Wallet Manager')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="ml-2 text-xl font-bold text-gray-800">Wallet Analytics</span>
                </div>
                
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('list') }}"
                       class="px-3 py-2 text-sm font-medium {{ request()->routeIs('list') ? 'bg-blue-100 text-blue-600 font-semibold rounded-md' : 'text-gray-500 hover:text-blue-600' }}">
                       Wallet List
                    </a>
                
                    <a href="{{ route('excel.import.form') }}"
                       class="px-3 py-2 text-sm font-medium {{ request()->routeIs('excel.import.form') ? 'bg-blue-100 text-blue-600 font-semibold rounded-md' : 'text-gray-500 hover:text-blue-600' }}">
                       Import Data
                    </a>
                
                    <a href="{{ route('good.wallet') }}"
                       class="px-3 py-2 text-sm font-medium {{ request()->routeIs('good.wallet') ? 'bg-blue-100 text-blue-600 font-semibold rounded-md' : 'text-gray-500 hover:text-blue-600' }}">
                       Good Wallet
                    </a>
                </nav>                
                <div class="md:hidden">
                    <button type="button" class="text-gray-500 hover:text-blue-600 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>