<div class="overflow-x-auto">
    <div class="relative w-full max-w-sm">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
            </svg>
        </div>
        <input type="text" placeholder="Search..." wire:model.live="search"
            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg   text-gray-800 placeholder-gray-400">
    </div>
    <table class="min-w-full border-2 border-gray-300 rounded-lg shadow-sm text-sm text-left table-auto mt-10">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border-2">No</th>
                <th class="px-4 py-2 border-2">Deskripsi</th>
                <th class="px-4 py-2 border-2">Level Krisis</th>
                <th class="px-4 py-2 border-2">Terakhir Diubah</th>
                <th class="px-4 py-2 border-2">Status</th>
                <th class="px-4 py-2 border-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($reports as $key => $row)
                <tr wire:key="report-{{ $row->id }}">
                    <td class="px-4 py-2 border-2">{{  $reports->firstItem() + $key }}</td>
                    <td class="px-4 py-2 border-2">
                        {{ Str::limit($row->report->deskripsi, 50) }}
                    </td>
                    <td class="px-4 py-2 border-2 flex justify-center items-center">
                        @switch($row->report->level_krisis)
                            @case('rendah')
                                <span class="bg-green-500 text-white rounded px-2 py-1">Rendah</span>
                            @break

                            @case('sedang')
                                <span class="bg-yellow-400 text-white rounded px-2 py-1">Sedang</span>
                            @break

                            @case('tinggi')
                                <span class="bg-red-500 text-white rounded px-2 py-1">Tinggi</span>
                            @break

                            @case('darurat')
                                <span class="bg-black text-white rounded px-2 py-1">Darurat</span>
                            @break

                            @default
                                <span class="bg-yellow-300 text-white rounded px-2 py-1">Belum Ditentukan</span>
                        @endswitch


                    </td>
                    <td class="px-4 py-2 border-2">{{ $row->updated_at->diffForHumans() }}</td>
                    <td class="px-4 py-2 border-2">
                        @switch($row->status)
                            @case('sent')
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-700">
                                    Dikirim
                                </span>
                            @break

                            @case('received')
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-700">
                                    Diterima
                                </span>
                            @break

                            @case('on_progress')
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-orange-100 text-orange-700">
                                    Pengerjaan
                                </span>
                            @break

                            @default
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-700">
                                    Selesai
                                </span>
                        @endswitch
                    </td>
                    <td class="px-4 py-2 border-2 text-center">
                        <a href="{{ route('instansi.dashboard.show', $row->id) }}" wire::navigate>
                            <button type="button"
                                class="px-2 py-1 bg-yellow-500 hover:bg-yellow-700 text-white rounded">
                                Detail
                            </button>
                        </a>

                        <button type="button" wire:click="openModal({{ $row->id }})"
                            class="px-2 py-1 bg-blue-500 hover:bg-blue-700 text-white rounded">
                            Update
                        </button>
                        
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">
                            Tidak ada laporan.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
        {{ $reports->links() }}
        <div
            class="{{ $selectedReport ? '' : 'hidden' }} fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded shadow-lg lg:w-[50%] lg:h-[65%] w-[70%] h-[80%]">
                <h2 class="text-lg font-semibold mb-4">Update Laporan</h2>

                <form wire:submit.prevent="updateReport" class="flex flex-col">
                    <label>Status:</label>
                    <select wire:model="status" class="w-full border rounded p-2 mb-3">
                        <option value="sent"
                            {{ in_array($status, ['received', 'on_progress', 'resolved']) ? 'disabled' : '' }}>
                            Dikirim
                        </option>
                        <option value="received" {{ in_array($status, ['on_progress', 'resolved']) ? 'disabled' : '' }}>
                            Terima
                        </option>
                        <option value="on_progress" {{ $status === 'resolved' ? 'disabled' : '' }}>Proses</option>
                        <option value="resolved">Selesai</option>
                    </select>



                    <label>Catatan Admin:</label>
                    <textarea wire:model="catatan_intansi" class="w-full h-[60%] border rounded p-2 mb-3"></textarea>




                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="closeModal"
                            class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
    <script>
        var pusher = new Pusher("hrc1og0mjabrrlcikvyw", {
            cluster: "",
            enabledTransports: ['ws'],
            forceTLS: false,
            wsHost: "127.0.0.1",
            wsPort: "8080"
        });

        var channel = pusher.subscribe("report_instansi");


        channel.bind("report.instansi", function(data) {
            console.log('event diterima');
            dispatchEvent(new CustomEvent('reportInstansiCreate', {
                detail: {
                    instansi_id: data.instansi_id,
                }
            }));

        });
    </script>
