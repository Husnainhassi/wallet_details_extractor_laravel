@extends('layouts.app')
@section('title', 'Import Wallet Data')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Qualified Wallets</h1>

        <!-- Filter Form -->
        <div class="bg-white p-4 rounded-lg shadow-md mb-6">
            @php
                $formAction = request()->is('good-wallet*') ? route('good.wallet') : route('list');
            @endphp
            <form method="GET" action="{{ $formAction }}" class="flex flex-wrap gap-4">
                <div class="w-full md:w-48">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Minimum Winrate</label>
                    <div class="relative rounded-md shadow-sm">
                        <input type="number" name="winrate_min" value="{{ request('winrate_min') }}" placeholder="0%"
                            step="0.01" min="0"
                            class="block w-full h-10 pl-3 pr-10 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 transition-all duration-200">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <span class="text-gray-500">%</span>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-48">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Minimum ROI</label>
                    <div class="relative rounded-md shadow-sm">
                        <input type="number" name="roi_min" value="{{ request('roi_min') }}" placeholder="0%"
                            step="0.01" min="0"
                            class="block w-full h-10 pl-3 pr-10 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 transition-all duration-200">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <span class="text-gray-500">%</span>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-48">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status"
                        class="block w-full h-10 pl-3 pr-10 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 transition-all duration-200"
                    >
                        <option value="" selected>Status</option>
                        <option value="in-review" {{ request('status') == 'in-review' ? 'selected' : '' }}>
                            In Review
                        </option>
                        <option value="disqualified" {{ request('status') == 'disqualified' ? 'selected' : '' }}>
                            Disqualified
                        </option>
                    </select>
                </div>

                <div class="self-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Filter
                    </button>
                    <a href="{{ $formAction }}"
                        class="ml-2 px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Results Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wallet
                            Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ROI</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Win Rate
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gmgn
                            Analyze</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($wallets as $wallet)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $wallet->wallet_address }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($wallet->roi, 2) }}%</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($wallet->win_rate, 2) }}%</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="flex items-center">
                                    <a href="https://gmgn.ai/sol/address/{{ $wallet->wallet_address }}" target="_blank"
                                        rel="noopener noreferrer" class="text-gray-400 hover:text-blue-500"
                                        aria-label="Open in new tab">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="flex items-center">
                                    <div class="flex items-center goodWallet cursor-pointer"
                                        data-wallet="{{ $wallet->wallet_address }}" data-roi="{{ $wallet->roi }}"
                                        data-winrate="{{ $wallet->win_rate }}">
                                        <img width="30" height="30"
                                            src="https://img.icons8.com/ios/50/thumb-up--v1.png" alt="thumb-up--v1" />
                                    </div>
                                    <div class="flex items-center disqualifed cursor-pointer"
                                        data-id="{{ $wallet->id }}">
                                        <img width="30" height="30"
                                            src="https://img.icons8.com/ios/50/thumbs-down.png" alt="thumbs-down" />
                                    </div>
                                    <div class="flex items-center in-review cursor-pointer" data-id="{{ $wallet->id }}">
                                        <img width="24" height="24" src="https://img.icons8.com/material-outlined/24/visible--v1.png" alt="visible--v1"/>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No wallets found
                                matching your criteria</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>  

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $wallets->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('.goodWallet').on('click', function() {
                var walletAddress = $(this).data('wallet');
                var roi = $(this).data('roi');
                var winRate = $(this).data('winrate');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to add this wallet to the Good Wallets list.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, add it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('add.good.wallet') }}",
                            type: 'POST',
                            data: {
                                wallet_address: walletAddress,
                                roi: roi,
                                win_rate: winRate,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    location.reload();
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Something went wrong. Please try again later.',
                                        'error'
                                    );
                                }
                            },
                            error: function() {
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while processing your request.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            $('.disqualifed').on('click', function() {
                var walletId = $(this).data('id'); // Get wallet ID from data-id attribute

                // Confirm the action before sending
                if (confirm('Are you sure you want to disqualify this wallet?')) {
                    // Send an AJAX request to the backend to mark the wallet as disqualified
                    $.ajax({
                        url: "{{ route('disqualify.wallet') }}",
                        method: 'POST',
                        data: {
                            id: walletId,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            // Handle success response
                            if (response.success) {
                                alert('Wallet has been disqualified!');
                                location.reload();
                                $(this).find('img').attr('src',
                                    'https://img.icons8.com/ios/50/thumbs-down-filled.png');
                            } else {
                                alert('Something went wrong.');
                            }
                        },
                        error: function() {
                            alert('Error occurred while disqualifying the wallet.');
                        }
                    });
                }
            });

            $('.in-review').on('click', function() {
                var walletId = $(this).data('id'); // Get wallet ID from data-id attribute

                // Confirm the action before sending
                if (confirm('Are you sure you want to review this wallet?')) {
                    // Send an AJAX request to the backend to mark the wallet as disqualified
                    $.ajax({
                        url: "{{ route('update.wallet.status') }}",
                        method: 'POST',
                        data: {
                            id: walletId,
                            status: 'in-review',
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            // Handle success response
                            if (response.success) {
                                alert('Wallet has been reviewed!');
                                location.reload();
                                $(this).find('img').attr('src',
                                    'https://img.icons8.com/ios/50/thumbs-down-filled.png');
                            } else {
                                alert('Something went wrong.');
                            }
                        },
                        error: function() {
                            alert('Error occurred while disqualifying the wallet.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
