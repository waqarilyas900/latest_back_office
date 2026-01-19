<div>
    @if($itemId && $itemCode)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
            <h4 class="text-sm font-medium text-blue-800 mb-2">Item Information</h4>
            <p class="text-sm text-blue-700"><strong>Item Code:</strong> {{ $itemCode }}</p>
            <p class="text-sm text-blue-700"><strong>Item ID:</strong> {{ $itemId }}</p>
            @if(!$allowAddNew)
                <p class="text-sm text-amber-700 mt-2"><strong>Mode:</strong> Update existing item codes only</p>
            @endif
        </div>
    @endif

    @if($allowAddNew)
        <button wire:click="addNewRow" class="bg-teal-500 text-white px-4 py-2 rounded mb-3">
            Add New Record
        </button>
    @endif

    <table class="w-full border-collapse border text-sm">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Item Code</th>
                <th class="border p-2">Payee</th>
                <th class="border p-2">Commands</th>
            </tr>
        </thead>
        <tbody>
            @foreach($itemCodes as $index => $row)
                <tr>
                    <td class="border p-2">
                        <input type="text" class="w-full border rounded p-1"
                               wire:model.defer="itemCodes.{{ $index }}.item_code">
                    </td>
                    <td class="border p-2">
                        <select class="w-full border rounded p-1"
                                wire:model.defer="itemCodes.{{ $index }}.payee_id">
                            <option value="">Select Payee</option>
                            @foreach($payees as $payee)
                                <option value="{{ $payee->id }}">{{ $payee->vendor_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="border p-2 text-center">
                        <button wire:click="saveRow({{ $index }})"
                                class="bg-green-500 text-white px-2 py-1 rounded mr-2">
                            💾
                        </button>
                        @if($row['id'])
                            <button wire:click="deleteRow({{ $row['id'] }})"
                                    class="bg-red-500 text-white px-2 py-1 rounded">
                                🗑
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
