<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Perangkat') }}
        </h2>
    </x-slot>

    <div class="py-9">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Search & Tombol Aksi -->
                    <div class="flex justify-between items-center mb-4">
                        <form action="{{ route('perangkat.index') }}" method="GET" class="flex items-center gap-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Enter Hostname..."
                                class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#981318]">
                            <button type="submit" class="p-2 bg-gray-100 rounded hover:bg-gray-200">🔍</button>
                        </form>

                        @auth
                            @if (auth()->user()->is_admin)
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('perangkat.create') }}" class="bg-[#981318] text-white px-4 py-2 rounded-md hover:bg-black">
                                        Tambah Data
                                    </a>
                                    <button id="importDataBtn" class="bg-[#981318] text-white px-4 py-2 rounded-md hover:bg-black">
                                        Impor Data
                                    </button>
                                    <form id="exportForm" action="{{ route('perangkat.export') }}" method="POST" class="hidden">
                                        @csrf
                                        <input type="hidden" name="hostnames[]" id="exportInput">
                                    </form>
                                    <button id="exportBtn" class="bg-[#981318] text-white px-4 py-2 rounded-md hover:bg-black">
                                        Ekspor Data
                                    </button>
                                </div>
                            @endif
                        @endauth
                    </div>

                    <!-- Tabel scrollable -->
                    <div class="overflow-auto max-h-[350px] border border-gray-300 rounded-md">
                        <table class="w-full text-sm border-collapse">
                            <thead class="bg-[#981318] text-white sticky top-0 z-10">
                                <tr id="headerRow">
                                    <th class="px-4 py-2 border checkbox-col">
                                        <input type="checkbox" id="selectAll">
                                    </th>
                                    <th class="px-4 py-2 border sortable" data-column-index="2" data-type="numeric">
                                        No
                                    <span class="sort-indicator"><span class="arrow-up"></span><span class="arrow-down"></span></span>
                                    </th>
                                    <th class="px-4 py-2 border sortable" data-column-index="3" data-type="alpha">
                                        STO
                                        <span class="sort-indicator"><span class="arrow-up"></span><span class="arrow-down"></span></span>
                                    </th>
                                    <th class="px-4 py-2 border sortable" data-column-index="4" data-type="alpha">
                                        Alamat
                                        <span class="sort-indicator"><span class="arrow-up"></span><span class="arrow-down"></span></span>
                                    </th>
                                    <th class="px-4 py-2 border sortable" data-column-index="5" data-type="alpha">
                                        Hostname
                                        <span class="sort-indicator"><span class="arrow-up"></span><span class="arrow-down"></span></span>
                                    </th>
                                    <th class="px-4 py-2 border sortable" data-column-index="6" data-type="alpha">
                                        IP Address
                                        <span class="sort-indicator"><span class="arrow-up"></span><span class="arrow-down"></span></span>
                                    </th>
                                    <th class="px-4 py-2 border sortable" data-column-index="7" data-type="alpha">
                                        Merek
                                        <span class="sort-indicator"><span class="arrow-up"></span><span class="arrow-down"></span></span>
                                    </th>
                                    <th class="px-4 py-2 border sortable" data-column-index="8" data-type="alpha">
                                        Jenis OLT
                                        <span class="sort-indicator"><span class="arrow-up"></span><span class="arrow-down"></span></span>
                                    </th>
                                    <th class="px-4 py-2 border">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody" class="text-center">
                                @forelse ($olts as $index => $olt)
                                    <tr data-hostname="{{ $olt->hostname_olt }}">
                                        <td class="px-4 py-2 border checkbox-col">
                                            <input type="checkbox" class="rowCheckbox">
                                        </td>
                                        <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2 border">{{ $olt->sto->sto ?? '-' }}</td>
                                        <td class="px-4 py-2 border">{{ $olt->alamat }}</td>
                                        <td class="px-4 py-2 border">{{ $olt->hostname_olt }}</td>
                                        <td class="px-4 py-2 border">{{ $olt->ip_address }}</td>
                                        <td class="px-4 py-2 border">{{ $olt->modelOlt->merek ?? '-' }}</td>
                                        <td class="px-4 py-2 border">{{ $olt->modelOlt->jenis_olt ?? '-' }}</td>
                                        <td class="px-4 py-2 border">
                                            <a href="{{ route('perangkat.show', $olt->id_olt) }}" class="text-blue-600 hover:underline">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-2 border text-gray-500">Tidak ada data Perangkat</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-xl font-bold">Impor Data Perangkat</h3>
                <button id="closeImportModal" class="text-gray-500 hover:text-gray-800 text-3xl">&times;</button>
            </div>
            <form action="{{ route('perangkat.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <p>Pilih file Excel (.xlsx) untuk diimpor.</p>
                    <div class="text-sm p-2 bg-blue-50 border border-blue-200 rounded-md">
                        <p class="font-semibold">Sebelum mengimpor, pastikan file Anda sesuai dengan format yang dibutuhkan.</p>
                        <a href="{{ route('perangkat.template') }}" class="text-blue-600 hover:underline font-bold">
                            Unduh Template Data Di Sini
                        </a>
                    </div>
                    <div>
                        <label for="file" class="block mb-1 font-medium">File</label>
                        <input type="file" name="file" id="file" class="w-full border p-2 rounded" accept=".xlsx,.xls,.csv">
                    </div>
                    <div class="flex justify-end items-center pt-4 space-x-4">
                        <button type="button" id="cancelImport" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600">Batal</button>
                        <button type="submit" class="bg-[#981318] text-white px-6 py-2 rounded-md hover:bg-black">Impor</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
// Script Ekspor
const exportBtn = document.getElementById('exportBtn');
const tableBodyForExport = document.getElementById('tableBody');
const exportForm = document.getElementById('exportForm');
let exportMode = false;

if (exportBtn) {
    exportBtn.addEventListener('click', () => {
        if (!exportMode) {
            document.querySelectorAll('.checkbox-col').forEach(td => td.classList.add('show'));
            document.getElementById('selectAll').addEventListener('change', function() {
                document.querySelectorAll('.rowCheckbox').forEach(cb => cb.checked = this.checked);
            });
            exportBtn.textContent = 'Ekspor Data Terpilih';
            exportMode = true;
        } else {
            exportForm.querySelectorAll('input[name="hostnames[]"]').forEach(i => i.remove());
            document.querySelectorAll('.rowCheckbox').forEach((cb, idx) => {
                if (cb.checked) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'hostnames[]';
                    input.value = tableBodyForExport.rows[idx].dataset.hostname;
                    exportForm.appendChild(input);
                }
            });
            exportForm.submit();
        }
    });
}
</script>

<script>
// Script Modal Import
document.addEventListener('DOMContentLoaded', function() {
    const importBtn = document.getElementById('importDataBtn');
    const importModal = document.getElementById('importModal');
    const closeImportModal = document.getElementById('closeImportModal');
    const cancelImport = document.getElementById('cancelImport');

    if (importBtn) {
        importBtn.addEventListener('click', () => {
            importModal.classList.remove('hidden');
            importModal.classList.add('flex');
        });
    }

    function hideImportModal() {
        importModal.classList.add('hidden');
        importModal.classList.remove('flex');
    }

    if (closeImportModal) closeImportModal.addEventListener('click', hideImportModal);
    if (cancelImport) cancelImport.addEventListener('click', hideImportModal);

    if (importModal) {
        importModal.addEventListener('click', (e) => {
            if (e.target === importModal) hideImportModal();
        });
    }
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
// ---Script Sorting ---
    const table = document.querySelector('table');
    if (table) {
        const headers = table.querySelectorAll('th.sortable');
        const tbody = table.querySelector('tbody');

        if (headers.length > 0 && tbody) {
            headers.forEach(header => {
                header.addEventListener('click', () => {
                    const columnIndex = header.dataset.columnIndex; 
                    if (!columnIndex) return; 

                    const type = header.dataset.type;
                    const currentIsAsc = header.classList.contains('asc');
                    const direction = currentIsAsc ? 'desc' : 'asc';

                    headers.forEach(h => h.classList.remove('asc', 'desc'));
                    header.classList.add(direction);

                    const rows = Array.from(tbody.querySelectorAll('tr'));
                    
                    rows.sort((a, b) => {
                        let valA_el = a.querySelector(`td:nth-child(${columnIndex})`);
                        let valB_el = b.querySelector(`td:nth-child(${columnIndex})`);

                        if (!valA_el || !valB_el) return 0;

                        let valA = valA_el.textContent.trim();
                        let valB = valB_el.textContent.trim();

                        if (type === 'numeric') {
                            valA = parseFloat(valA) || 0;
                            valB = parseFloat(valB) || 0;
                        }

                        if (valA < valB) return direction === 'asc' ? -1 : 1;
                        if (valA > valB) return direction === 'asc' ? 1 : -1;
                        return 0;
                    });
                    
                    while (tbody.firstChild) {
                        tbody.removeChild(tbody.firstChild);
                    }
                    rows.forEach(row => tbody.appendChild(row));
                });
            });
        }
    }
});
</script>