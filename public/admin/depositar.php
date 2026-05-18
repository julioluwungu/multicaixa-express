<?php require_once "../../includes/admin_auth.php"; ?>

<div class="container">

    <h2>Depósito Admin</h2>

    <form action="../../actions/admin_depositar.php" method="POST">

        <div class="input-group">
            <label>Email do usuário</label>
            <input type="email" name="email" required>
        </div>

        <div class="input-group">
            <label>Valor</label>
            <input type="number" name="valor" step="0.01" required>
        </div>

        <button type="submit">Depositar</button>

    </form>

</div>