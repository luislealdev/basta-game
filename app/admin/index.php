<?php
session_start();
if (!isset($_SESSION["nombre"])) header('location: .,/auth?m=5');
if (!$_SESSION["role"] == 'admin') header('location: ../auth?error=401');

include './components/navbar.php';
?>

<h1>Admin Panel</h1>
<!-- TODO: ADD LIST OF WORDS: BUTTON OF DELETE, EDIT -->
</main>
</body>

</html>

<script>
    document.title = "Admin Panel";
</script>