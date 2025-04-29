<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        .table td {
            font-size: 0.9rem;
        }
        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Filter Token Transactions</h1>

        <form method="POST" action="{{ route('transactions') }}">
            @csrf

            <div class="mb-3">
                <label>Token Address</label>
                <input type="text" name="token_address" class="form-control" placeholder="e.g. 7x1...yX9" required>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label>Start Time</label>
                    <input type="datetime-local" name="start_time" class="form-control" required>
                </div>
                <div class="col">
                    <label>End Time</label>
                    <input type="datetime-local" name="end_time" class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Fetch Transactions</button>
        </form>

        @isset($transactions)
            <h3 class="mt-4">Transactions ({{ count($transactions) }})</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Amount</th>
                            <th>Wallet</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $tx)
                            <tr>
                                <td>{{ $tx['time'] }}</td>
                                <td><span class="badge {{ $tx['type'] === 'Buy' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $tx['type'] }}
                                    </span></td>
                                <td>{{ number_format($tx['price'], 4) }}</td>
                                <td>{{ number_format($tx['amount'], 2) }}</td>
                                <td>
                                    <a href="https://solscan.io/account/{{ $tx['address'] }}" target="_blank"
                                        class="text-truncate" style="max-width: 120px; display: inline-block">
                                        {{ $tx['address'] }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endisset
    </div>
</body>

</html>
