<!DOCTYPE html>
<html>
<head>
    <title>Birdeye Request</title>
</head>
<body>
    <h1>Sending POST Request to Birdeye API...</h1>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch("https://multichain-api.birdeye.so/solana/amm/v2/txs/token", {
                method: "POST",
                headers: {
                    "Host": "multichain-api.birdeye.so",
                    "Accept-Encoding": "gzip, deflate, br, zstd",
                    "Referer": "https://birdeye.so/",
                    "Origin": "https://birdeye.so",
                    "Connection": "keep-alive",
                    "Sec-Fetch-Dest": "empty",
                    "Sec-Fetch-Mode": "cors",
                    "Sec-Fetch-Site": "same-site",
                    "TE": "trailers",
                    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0",
                    "Accept": "application/json",
                    "Accept-Language": "en-US,en;q=0.5",
                    "agent-id": "798a68bf-0a57-46aa-a726-71df0358a741",
                    "content-type": "application/json",
                    "page": "find-trades",
                    "Priority": "u=0"
                },
                body: JSON.stringify({
                    "offset": 30,
                    "limit": 50,
                    "export": false,
                    "query": [
                        {
                            "keyword": "side",
                            "operator": "term",
                            "value": "trade"
                        },
                        {
                            "keyword": "blockUnixTime",
                            "operator": "gte",
                            "value": 1745215380
                        },
                        {
                            "keyword": "blockUnixTime",
                            "operator": "lte",
                            "value": 1745215800
                        }
                    ],
                    "sort_by": "",
                    "sort_type": "",
                    "address": "5UUH9RTDiSpq6HKS6bp4NdU9PNJpXRXuiw6ShBTBhgH2",
                    "latest_id": "6805e13ae3c8181707616a36"
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Success:", data);
                document.body.innerHTML += `<pre>${JSON.stringify(data, null, 2)}</pre>`;
            })
            .catch(error => {
                console.error("Error:", error);
                document.body.innerHTML += `<p style="color: red;">Request failed. Check console for details.</p>`;
            });
        });
    </script>
</body>
</html>

