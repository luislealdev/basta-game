<?
session_start();
if (!isset($_SESSION["nombre"])) header('location: auth.php?m=5');
if (!$_SESSION["role"] == 'admin') header('location: ../auth/login.php?error=401');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>

<body>
    <h1>Admin Panel</h1>
</body>

</html>