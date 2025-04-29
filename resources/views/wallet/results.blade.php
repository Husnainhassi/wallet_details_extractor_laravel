
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  </head>
  <body>
    <div class="container">
        <h1>Qualified Wallets</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Wallet Address</th>
                    <th>ROI</th>
                    <th>Win Rate</th>
                </tr>
            </thead>
            <tbody>
                @foreach($wallets as $wallet)
                <tr>
                    <td><a href="https://gmgn.ai/sol/address/{{ $wallet['address'] }}" target="_blank">{{ $wallet['address'] }}</a></td>
                    <td>{{ $wallet['roi'] }}%</td>
                    <td>{{ $wallet['winrate'] }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </body>
</html>