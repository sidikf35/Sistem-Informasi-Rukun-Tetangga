<?php
// =====================================================
// FILE: views/partials/footer.php
// FUNGSI: Footer untuk halaman dashboard
// =====================================================
?>
<script>
console.log('SIRT App siap digunakan');

// Auto hide alert setelah 3 detik
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        alert.style.opacity = '0';
        setTimeout(function() {
            if (alert) alert.remove();
        }, 500);
    });
}, 3000);
</script>
</body>

</html>