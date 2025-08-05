<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Transaction Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('transactions.edit', $transaction) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Transaction Amount -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-2">Amount</h3>
                            <p class="text-2xl font-bold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                ${{ number_format($transaction->amount, 2) }}
                            </p>
                        </div>

                        <!-- Transaction Type -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-2">Type</h3>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $transaction->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($transaction->type) }}
                            </span>
                        </div>

                        <!-- Transaction Category -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-2">Category</h3>
                            <p class="text-gray-700">{{ ucfirst(str_replace('_', ' ', $transaction->category)) }}</p>
                        </div>

                        <!-- Transaction Date -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-2">Date</h3>
                            <p class="text-gray-700">{{ $transaction->transaction_date->format('F d, Y') }}</p>
                        </div>

                        <!-- Description -->
                        <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                            <h3 class="text-lg font-semibold mb-2">Description</h3>
                            <p class="text-gray-700">{{ $transaction->description }}</p>
                        </div>

                        <!-- Timestamps -->
                        <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                            <h3 class="text-lg font-semibold mb-2">Record Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                                <p><strong>Created:</strong> {{ $transaction->created_at->format('F d, Y g:i A') }}</p>
                                <p><strong>Last Updated:</strong> {{ $transaction->updated_at->format('F d, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 flex justify-end space-x-2">
                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" 
                                    onclick="return confirm('Are you sure you want to delete this transaction? This action cannot be undone.')">
                                Delete Transaction
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>