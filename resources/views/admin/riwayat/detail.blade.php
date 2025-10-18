<x-layout_admin>
    <x-slot:judul>{{ $judul }}</x-slot:judul>
    <livewire:admin-riwayat-detail :id="$id" />
    <x-sweet-alert />
</x-layout_admin>