<?php

require_once "../../includes/admin_auth.php";

?>

<div class="container">

    <h2>Criar Admin</h2>

    <form action="../../actions/criar_admin.php" method="POST">

        <div class="input-group">
            <label>Email do usuário</label>
            <input type="email" name="email" required>
        </div>

        <button type="submit">Tornar Admin</button>

    </form>

</div>