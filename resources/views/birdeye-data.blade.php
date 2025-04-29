<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Birdeye Data</title>
</head>
<body>
    <h1>Birdeye Trade Data</h1>
    <pre id="responseBox">Loading...</pre>

    <script>
         fetch('/proxy-birdeye', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                "offset": 15,
                "limit": 15,
                "export": false,
                "query": [
                    { "keyword": "side", "operator": "term", "value": "trade" },
                    { "keyword": "blockUnixTime", "operator": "gte", "value": 1745341200 }
                ],
                "sort_by": "",
                "sort_type": "",
                "address": "F14hCmEKjcaXobNE2fMdRX9EcetC2oNuiZVjpce1iohE",
                "latest_id": "6807e2e1e3c8181707e823bc"
            })
        })
        .then(res => res.json())
        .then(data => console.log(data))
        .catch(err => console.error(err));
    </script>
</body>
</html>
