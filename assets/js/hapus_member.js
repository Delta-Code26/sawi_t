
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil semua tombol Hapus dengan class "btn-danger"
        var deleteButtons = document.querySelectorAll(".btn-danger");

        // Loop melalui setiap tombol Hapus
        deleteButtons.forEach(function(button) {
            // Tambahkan event listener untuk setiap tombol Hapus
            button.addEventListener("click", function(event) {
                // Tampilkan konfirmasi sebelum menghapus
                var confirmation = confirm("Apakah Anda yakin ingin menghapus data ini?");

                // Jika pengguna mengonfirmasi, lanjutkan dengan mengirimkan form
                if (confirmation) {
                    // Temukan form terdekat dari tombol yang diklik
                    var form = button.closest("form");

                    // Setel aksi form menjadi tautan yang diklik
                    form.action = button.getAttribute("href");

                    // Setel metode form menjadi "POST"
                    form.method = "POST";

                    // Submit form
                    form.submit();
                } else {
                    // Mencegah tindakan default jika pengguna membatalkan
                    event.preventDefault();
                }
            });
        });
    });

