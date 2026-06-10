<!DOCTYPE html>
<html>
<head>
    <title>Products Report</title>
</head>
<body>
    <h2>Products Report</h2>

    <table border="1" width="100%" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
        </tr>

        @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>