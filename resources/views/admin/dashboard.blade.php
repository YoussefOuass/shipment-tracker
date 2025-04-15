<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        h1 {
            margin: 0;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li {
            margin: 10px 0;
        }
        ul li a {
            display: block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        ul li a:hover {
            background-color: #0056b3;
        }
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .btn-back:hover {
            background-color: #218838;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #f4f4f9;
            color: #555;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to the Admin Panel</h1>
    </header>
    <div class="container">
        <h2>Quick Links</h2>
        <ul>
            <li><a href="{{ route('customers.index') }}" class="btn btn-primary">Manage Customers</a></li>
            <li><a href="{{ route('users.index') }}" class="btn btn-primary">Manage Users</a></li>
            <li><a href="{{ route('shipments.index') }}" class="btn btn-primary">Manage Shipments</a></li>
            <li><a href="{{ route('carriers.index') }}" class="btn btn-primary">Manage Carriers</a></li>
        </ul>
        <!-- Back to Home Button -->
        <a href="{{ route('admin.home') }}" class="btn btn-secondary">Back to Home</a>    <footer>
        &copy; {{ date('Y') }} Shipment Tracker. All rights reserved.
    </footer>
</body>
</html>