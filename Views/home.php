<?php get_header('public', $data); ?>
<?php load_template('landing', $data); ?>


<!-- Scripts adicionales -->
<?php if (isset($data['js_files'])): ?>
    <?php foreach ($data['js_files'] as $js): ?>
        <script src="<?= media(); ?>js/<?= $js; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

<script>
'use strict';
const base_url = "<?= base_url(); ?>";
const page_name = "<?= $data['page_name'] ?? ''; ?>";
const controller = "<?= $data['controller'] ?? ''; ?>";
</script>

<!-- Inicialización de la app -->
<?php if (isset($data['page_name']) && isset($data['controller'])): ?>
<script>
window.addEventListener('load', function() {
    const app = new Controller(
        new Model(controller.toLowerCase(), page_name),
        new View(controller)
    );
}, false);
</script>
<?php endif; ?>

<?php get_footer('public', $data); ?>
