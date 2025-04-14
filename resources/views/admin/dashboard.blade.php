<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome to the Admin Panel</h1>
    <ul>
        <li><a href="{{ route('users.index') }}">Manage Users</a></li>
        <li><a href="{{ route('shipments.index') }}">Manage Shipments</a></li>
        <li><a href="{{ route('carriers.index') }}">Manage Carriers</a></li>
    </ul>
</body>
</html>