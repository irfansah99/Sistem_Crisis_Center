<x-layout_admin>
    <x-slot:judul>{{ $judul }}</x-slot:judul>

    <livewire:report-detail :id="$id" />

    <script>
        function openModal() {
            document.getElementById("modal").classList.toggle("hidden");
        }

        function openInstansi() {
            const instansiDiv = document.getElementById("instansi");
            const button = document.getElementById("instansi_button");

            instansiDiv.classList.toggle("hidden");

            if (!instansiDiv.classList.contains("hidden")) {
                button.innerHTML = "Tutup Instansi";
            } else {
                button.innerHTML = "Tambah Instansi";
            }
        }
    </script>

    <x-sweet-alert />
</x-layout_admin>
