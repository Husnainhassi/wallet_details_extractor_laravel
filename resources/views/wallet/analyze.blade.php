<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
      <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-2xl">
        <h1 class="text-2xl font-bold text-center mb-6">Wallet Analyzer</h1>
        <form method="POST" action="{{ route('analyze.post') }}" enctype="multipart/form-data" class="space-y-4">
          @csrf
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Excel File</label>
            <input type="file" name="csv_file" accept=".xlsx, .xls" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
          <div class="text-center">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Analyze</button>
          </div>
        </form>

        <!-- Results Table -->
        @if(isset($results) && count($results) > 0)
        <div class="mt-6">
          <h2 class="text-lg font-semibold mb-4">Analysis Results</h2>
          <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 text-sm text-left">
              <thead class="bg-gray-100">
                <tr>
                  @foreach($results[0] as $key => $value)
                  <th class="px-4 py-2 border-b border-gray-300 font-medium text-gray-700">{{ $key }}</th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                @foreach($results as $row)
                <tr class="hover:bg-gray-50">
                  @foreach($row as $cell)
                  <td class="px-4 py-2 border-b border-gray-300">{{ $cell }}</td>
                  @endforeach
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        @endif
      </div>
    </div>
  </body>
</html>