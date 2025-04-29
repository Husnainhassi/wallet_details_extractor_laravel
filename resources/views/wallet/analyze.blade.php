
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  </head>
  <body>
    <div class="container">
        <h1>Wallet Analyzer</h1>
        <form method="POST" action="{{ route('analyze') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="file" class="form-control" name="csv_file" accept=".csv">
            </div>
            <button type="submit" class="btn btn-primary">Analyze</button>
        </form>
    </div>
  </body>
</html>