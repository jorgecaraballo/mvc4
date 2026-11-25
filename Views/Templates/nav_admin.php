<?php 
// Verificamos que haya sesión activa para los datos del usuario
$userName = $_SESSION['userData']['nombres'] ?? 'Admin';
?>
    <header>
        <button class="menu-toggle" id="menuToggle">☰</button>
        <h1>Node 113 Admin</h1>
        <div><?= htmlspecialchars($userName); ?></div>
    </header>

    <aside id="sidebar">
        <h2>Menú Principal</h2>
        <ul>
            <?php if (tienePermiso(1)): ?>
                <li><a href="<?= base_url(); ?>dashboard" <?= (isset($data['page_name']) && $data['page_name'] == 'dashboard') ? 'style="color: var(--accent-color);"' : ''; ?>>Dashboard</a></li>
            <?php endif; ?>

            <?php if (tienePermiso(2)): ?>
                <li><a href="<?= base_url(); ?>roles" <?= (isset($data['page_name']) && $data['page_name'] == 'roles') ? 'style="color: var(--accent-color);"' : ''; ?>>Roles</a></li>
            <?php endif; ?>

            <?php if (tienePermiso(3)): ?>
                <li><a href="<?= base_url(); ?>usuarios" <?= (isset($data['page_name']) && $data['page_name'] == 'usuarios') ? 'style="color: var(--accent-color);"' : ''; ?>>Usuarios</a></li>
            <?php endif; ?>

            <!-- Aquí añadirás los futuros módulos (Videos, Audios, etc.) -->
            <!-- Ejemplo: if (tienePermiso(4)): ... endif; -->

            <li><a href="<?= base_url(); ?>logout">Logout</a></li>
        </ul>
    </aside>
