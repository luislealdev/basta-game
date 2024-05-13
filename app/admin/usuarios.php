<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
// if (!isset($_SESSION["nombre"])) header('location: .,/auth?m=5');
// if (!$_SESSION["role"] == 'admin') header('location: ../auth?error=401');

include '../../components/navbar.php';
?>
<script src="../../utils/usuario.js"></script>
<div class="container" id="workArea">
    <?php include "../../class/usuario.php"; ?>
</div>

</body>

</html>

<script>
    document.title = "Usuarios";
</script>