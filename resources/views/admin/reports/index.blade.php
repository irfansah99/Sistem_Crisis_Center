<x-layout_admin>
    <x-slot:judul>{{ $judul }}</x-slot:judul>
    @livewire('report-list')

    <x-sweet-alert />
</x-layout_admin>
