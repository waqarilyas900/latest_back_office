<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Price Change History</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Cost</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Retail</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">App Type</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Page Source</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($histories as $history)
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $history->created_at->format('n/j/Y g:i:s A') }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $history->item->item_description ?? 'N/A' }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">${{ number_format($history->item->case_cost ?? 0,2) }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">${{ number_format($history->new_price,2) }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $history->user->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $history->app_type ?? '' }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $history->page_source ?? '' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                            <p class="text-sm">No price change history available.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-3">
        {{ $histories->links() }}
    </div>
</div>
