<x-layout_admin>
    <x-slot:judul>{{ $judul }}</x-slot:judul>

    <div class="overflow-x-auto w-full">
        <table class="min-w-full border-2  border-gray-300 rounded-lg shadow-sm text-sm text-left table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border-2">No</th>
                    <th class="px-4 py-2 border-2">username</th>
                    <th class="px-4 py-2 border-2">bulan</th>
                    <th class="px-4 py-2 border-2">Daya</th>
                    <th class="px-4 py-2 border-2">Pemakaian</th>
                    <th class="px-4 py-2 border-2">Total</th>
                    <th class="px-4 py-2 border-2">Terakhir diubah</th>
                    <th class="px-4 py-2 border-2">Status</th>
                    <th class="px-4 py-2 border-2 ">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($tagihan as $row)
                    <tr>
                        <td class="px-4 py-2 border-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border-2 text-wrap">{{ $row->pelanggan->username }}</td>
                        <td class="px-4 py-2 border-2 text-wrap">{{ $row->bulan }} {{ $row->tahun }}</td>
                        <td class="px-4 py-2 border-2 text-wrap text-justify">{{ $row->pelanggan->tarif->daya }} w </td>
                        <td class="px-4 py-2 border-2 text-wrap text-justify">{{ $row->jumlah_meter }} kwh</td>
                        <td class="px-4 py-2 border-2 text-wrap text-justify">Rp {{ number_format($row->total, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 border-2 text-wrap text-justify">{{ $row->updated_at->translatedFormat('l, d F Y') }}</td>
                        <td class="px-4 py-2 border-2 text-wrap text-justify">
                            @if ($row->status == 'Belum Bayar')
                                <span class="text-red-500">{{ $row->status }}</span>
                            @elseif ($row->status == 'Menunggu')
                                <span class="text-yellow-500">{{ $row->status }}</span>
                            @else
                                <span class="text-blue-500">{{ $row->status }}</span>
                            @endif
                        </td>                    
                        <td class="px-4 py-2 border-2">
                            <div class="m-auto flex gap-2 items-center justify-center">
                                @if ($row->status === 'Belum Bayar')
                                    <button
                                    type="button"
                                    disabled
                                    class="bg-blue-200 text-white px-3 py-1 rounded-md pointer-events-none"
                                    >
                                    Konfirmasi
                                    </button>
                                    <button
                                    type="button"
                                    disabled
                                    onclick="konfirmasireject({{ $row->id_tagihan }})"
                                    class="bg-red-200 text-white px-3 py-1 rounded-md pointer-events-none"
                                    >
                                    Belum Bayar
                                    </button>
                            
                            @elseif ($row->status  === 'Menunggu')
                                <form
                                id="form-konfirmasi-{{ $row->id_tagihan }}"
                                action="{{ route('kelola_tagihan.update', $row->id_tagihan) }}"
                                method="POST"
                                data-total="{{ $row->total }}"
                            >
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="Sudah Bayar">
                                <button
                                    type="button"
                                    onclick="konfirmasi({{ $row->id_tagihan }})"
                                    class="bg-green-500 hover:bg-green-700 text-white px-3 py-1 rounded-md"
                                >
                                    Konfirmasi
                                </button>
                            </form>
                            
                            <form
                                id="form-reject-{{ $row->id_tagihan }}"
                                action="{{ route('kelola_tagihan.update', $row->id_tagihan) }}"
                                method="POST"
                                data-total="{{ $row->total }}"
                            >
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="Belum Bayar">
                                <button
                                    type="button"
                                    onclick="konfirmasireject({{ $row->id_tagihan }})"
                                    class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded-md"
                                >
                                    Belum Bayar
                                </button>
                            </form>
                        
                              @endif
                        </div>
                    </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center  py-4 text-gray-500 ">
                            Tidak ada Tagihan.
                        </td>
                    </tr>
                @endforelse
    
            </tbody>
        </table>
        <x-sweet-alert />
    </div>
    

</x-layout_admin>
  