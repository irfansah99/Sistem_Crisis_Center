@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: @json(session('success')),
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: @json(session('error')),
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif
<script>
    window.addEventListener('sweet-alert', event => {
        const detail = event.detail;

        Swal.fire({
            icon: detail.icon,
            title: detail.title,
            text: detail.text || '',
            showConfirmButton: detail.showConfirmButton ?? false,
            timer: detail.timer ?? 2000
        });
    });
</script>

<script>
    window.addEventListener('sweet-alert', event => {
        const detail = event.detail;

        if (detail.type === 'confirm') {
            Swal.fire({
                icon: detail.icon,
                title: detail.title,
                text: detail.text,
                showCancelButton: true,
                confirmButtonText: detail.confirmButtonText || 'Ya',
                cancelButtonText: detail.cancelButtonText || 'Batal',
            }).then((result) => {
                if (result.isConfirmed && detail.jenis ==='deletereport' ) {
                    Livewire.dispatch('deleteConfirmed');
                }
                if (result.isConfirmed && detail.jenis ==='perbaruiakun' ) {
                    Livewire.dispatch('updateconfirm');
                }
            });
        } else {
            Swal.fire({
                icon: detail.icon,
                title: detail.title,
                text: detail.text || '',
                showConfirmButton: detail.showConfirmButton ?? false,
                timer: detail.timer ?? 1000
            });
        }
    });
</script>


<script>
    function konfirmasiubah(id) {
        const form = document.getElementById('form-ubah-' + id);
        const total = parseInt(form.dataset.total);
        const admin = 2000;
        const totalBayar = total + admin;

        Swal.fire({
            title: 'Yakin ingin membayar?',
            html: `
                <p>Total Tagihan: <strong>Rp ${total.toLocaleString('id-ID')}</strong></p>
                <p>Biaya Admin: <strong>Rp ${admin.toLocaleString('id-ID')}</strong></p>
                <hr>
                <p>Total yang harus dibayar: <strong class="text-red-600">Rp ${totalBayar.toLocaleString('id-ID')}</strong></p>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, bayar!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    function konfirmasiperbarui(id) {
        Swal.fire({
            title: 'Yakin ingin memperbarui data?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, perbarui!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-ubah-' + id).submit();
            }
        });
    }

    function konfirmasi(id) {
        Swal.fire({
            title: 'Yakin ingin mengkonfirmasi pembayaran?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Konfirmasi',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-konfirmasi-' + id).submit();
            }
        });
    }

    function konfirmasireject(id) {
        Swal.fire({
            title: 'Yakin ingin menolak pembayaran?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Tolak',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-reject-' + id).submit();
            }
        });
    }

    function konfirmasiHapus(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ok',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-hapus-' + id).submit();
            }
        })
    }
</script>
