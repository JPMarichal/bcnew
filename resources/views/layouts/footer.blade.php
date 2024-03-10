<div class="border p-2">Este es el footer.</div>
</div> <!-- Cierre del container -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- TinyMCE -->
<script src="{{ asset('js/tinymce-setup.js') }}"></script>

<script type="text/javascript">
    $('#contactForm').submit(function() {
    tinymce.triggerSave(); // Esto fuerza a TinyMCE a guardar el contenido actual en el textarea
});
</script>
</body>
</html>
