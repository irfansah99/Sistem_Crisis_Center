<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bidding</title>
</head>
<body>

<table id="table-bid" border="1" style="font-size: 40px">
    <tr>
        <td>NAME</td>
        <td>PRICE</td>
    </tr>
</table>

<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
<script>
    // ganti dengan REVERB / PUSHER APP KEY kamu
    var pusher = new Pusher("hrc1og0mjabrrlcikvyw", {
        cluster: "", 
        enabledTransports: ['ws'],
        forceTLS:false,
        wsHost: "127.0.0.1",
        wsPort: "8080"
    });

    var channel = pusher.subscribe("bid-placed");

    // pakai nama event sesuai broadcastAs()
    channel.bind("bid.placed", function(data) {
        let tableBid = document.getElementById('table-bid');
        var row = tableBid.insertRow();
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        cell1.innerHTML = data.name;
        cell2.innerHTML = data.price;
    });
</script>

</body>
</html>
