<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Penghutang Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #343a40;
            padding: 10px 0;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        nav ul li {
            display: inline-block;
            margin-right: 20px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
        .container {
            width: 90%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        input[type="text"], input[type="number"], input[type="date"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Catat Penghutang Baru</a></li>
            <li><a href="data.php">Kelola Penghutang</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Catat Penghutang Baru</h2>
        <form action="save_debtor.php" method="post">
            <input type="text" name="name" placeholder="Nama" required>
            <input type="text" name="phone" placeholder="No. HP" required>
            <input type="number" name="amount" placeholder="Jumlah Hutang" required>
            <input type="date" name="due_date" required>
            <input type="submit" value="Simpan">
        </form>
        <div id="message" style="color: green; text-align: center;"></div>
    </div>
</body>
</html>
