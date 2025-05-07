@extends('layouts.app')
@section('title', 'Import Wallet Data')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Import Wallet Data</h1>
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
            
            <form action="{{ route('wallet.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Excel File</label>
                    <div class="mt-1 flex items-center">
                        <input  type="file"  name="excel_file"  id="excel_file" accept=".xlsx,.xls,.csv"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0
                            file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">
                        Please upload an Excel file with WalletAddress, ROI, and Winrate columns.
                    </p>
                </div>
                
                <div class="flex items-center justify-between">
                    <a href="{{ route('list') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                        Back to Wallet List
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Import Data
                    </button>
                </div>
            </form>
            
            <div class="mt-8 border-t border-gray-200 pt-6">
                <h2 class="text-lg font-medium text-gray-900 mb-2">File Requirements</h2>
                <ul class="list-disc pl-5 space-y-1 text-sm text-gray-600">
                    <li>File must be in .xlsx, .xls, or .csv format</li>
                    <li>Required columns: WalletAddress, ROI, Winrate</li>
                    <li>First row should contain column headers</li>
                    <li>ROI and Winrate should be numeric values</li>
                </ul>
            </div>
        </div>
    </div>
@endsection