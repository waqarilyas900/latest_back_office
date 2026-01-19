<div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
    <ul class="flex flex-wrap -mb-px">
        <li class="me-2">
            <a href="{{ route('products.items') }}" 
               class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 {{ Route::is('products.items') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent' }}"
               @if(Route::is('products.items')) aria-current="page" @endif>Items</a>
        </li>
        <li class="me-2">
            <a href="{{ route('products.pricebook.index') }}" 
               class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 {{ Route::is('products.pricebook.*') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent' }}"
               @if(Route::is('products.pricebook.*')) aria-current="page" @endif>Price Book</a>
        </li>
        <li class="me-2">
            <a href="{{ route('price-group') }}" 
               class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 {{ Route::is('price-group') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent' }}"
               @if(Route::is('price-group')) aria-current="page" @endif>Price Group</a>
        </li>
        <li class="me-2">
            <a href="{{ route('product-categories') }}" 
               class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 {{ Route::is('product-categories') ? 'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500' : 'border-transparent' }}"
               @if(Route::is('product-categories')) aria-current="page" @endif>Categories</a>
        </li>
        <li class="me-2">
            <a href="#" 
               class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Manufacturers</a>
        </li>
        
    </ul>
</div>
