<footer class="admin-footer text-center py-3">
    <div class="container">
        <small>&copy; {{ date('Y') }} BMTPC - Mobile App Content Administration | Version 1.0</small>
    </div>
</footer>



<script src="{{ asset('public/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content', {
        height: 150,
        versionCheck: false
    });
</script>