<?php get_header('public', $data); ?>

<main class="blog-container">
    <article class="blog-article">
        <?= $data['html_content']; ?>
    </article>
</main>

<!-- Scripts específicos de página -->
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
const slug = "<?= $data['slug'] ?? ''; ?>"; // <-- Pasamos el slug al frontend
</script>

<!-- Inicialización de la app -->
<script>
window.addEventListener('load', function() {
    const app = new Controller(
        new Model(controller.toLowerCase(), page_name),
        new View(controller)
    );
}, false);
</script>

<?php get_footer('public', $data); ?>
