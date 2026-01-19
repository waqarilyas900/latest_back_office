<div>
    @if(!$selectedItemId)
        <div class="text-red-500 font-medium">
            Please scan/select an item first in the Items tab.
        </div>
    @else
        {{-- Scan code + pack qty --}}
        <div class="grid grid-cols-5 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium">Scan Code</label>
                <input type="text" wire:model.lazy="scanCode" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Mapped Qty</label>
                <input type="number" wire:model.defer="packQty" class="w-full border rounded p-2">
            </div>
            <div class="flex items-end gap-2 col-span-2">
                <button wire:click="saveMapping"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Save
                </button>
                <button wire:click="$reset(['scanCode','mappedItemId','packQty','description','cost','retail','department_id'])"
                        class="border px-4 py-2 rounded">
                    Clear
                </button>
            </div>
        </div>

        {{-- ✅ Show these fields only when code NOT found (new item) --}}
        @if(!$mappedItemId && $scanCode)
            <div class="grid grid-cols-4 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium">Description</label>
                    <input type="text" wire:model.defer="description" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium">Cost</label>
                    <input type="text" wire:model.defer="cost" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium">Retail</label>
                    <input type="text" wire:model.defer="retail" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium">Department</label>
                    <select wire:model.defer="department_id" class="w-full border rounded p-2">
                        <option value="">Select Department</option>
                        @foreach(\App\Models\Department::all() as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

        {{-- Mappings table --}}
        <h3 class="font-semibold mb-2">Single Item Mappings</h3>
        <table class="w-full border-collapse border text-sm">
            <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Scan Code</th>
                <th class="border p-2">Description</th>
                <th class="border p-2">Pack Qty</th>
                <th class="border p-2">Unit Cost</th>
                <th class="border p-2">Unit Retail</th>
            </tr>
            </thead>
            <tbody>
            @forelse($existingMappings as $mapping)
                <tr>
                    <td class="border p-2">{{ $mapping->mappedItem->code }}</td>
                    <td class="border p-2">{{ $mapping->mappedItem->item_description }}</td>
                    <td class="border p-2">{{ $mapping->pack_qty }}</td>
                    <td class="border p-2">{{ $mapping->mappedItem->case_cost }}</td>
                    <td class="border p-2">{{ $mapping->mappedItem->unit_retail }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="border p-2 text-center text-gray-500">No mappings yet.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    @endif
</div>
