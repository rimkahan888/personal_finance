<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('transactions.store') }}">
                        @csrf

                        <!-- Amount -->
                        <div class="mb-4">
                            <x-input-label for="amount" :value="__('Amount')" />
                            <x-text-input id="amount" class="block mt-1 w-full" type="number" step="0.01" name="amount" :value="old('amount')" required autofocus />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <!-- Type -->
                        <div class="mb-4">
                            <x-input-label for="type" :value="__('Type')" />
                            <select id="type" name="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Type</option>
                                <option value="income" {{ old('type') === 'income' ? 'selected' : '' }}>Income</option>
                                <option value="expense" {{ old('type') === 'expense' ? 'selected' : '' }}>Expense</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="category" :value="__('Category')" />
                            <select id="category" name="category" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Category</option>
                                <!-- Income Categories -->
                                <optgroup label="Income Categories" id="income-categories" style="display: none;">
                                    <option value="salary" {{ old('category') === 'salary' ? 'selected' : '' }}>Salary</option>
                                    <option value="freelance" {{ old('category') === 'freelance' ? 'selected' : '' }}>Freelance</option>
                                    <option value="investment" {{ old('category') === 'investment' ? 'selected' : '' }}>Investment</option>
                                    <option value="other_income" {{ old('category') === 'other_income' ? 'selected' : '' }}>Other Income</option>
                                </optgroup>
                                <!-- Expense Categories -->
                                <optgroup label="Expense Categories" id="expense-categories" style="display: none;">
                                    <option value="food" {{ old('category') === 'food' ? 'selected' : '' }}>Food</option>
                                    <option value="transportation" {{ old('category') === 'transportation' ? 'selected' : '' }}>Transportation</option>
                                    <option value="utilities" {{ old('category') === 'utilities' ? 'selected' : '' }}>Utilities</option>
                                    <option value="entertainment" {{ old('category') === 'entertainment' ? 'selected' : '' }}>Entertainment</option>
                                    <option value="healthcare" {{ old('category') === 'healthcare' ? 'selected' : '' }}>Healthcare</option>
                                    <option value="shopping" {{ old('category') === 'shopping' ? 'selected' : '' }}>Shopping</option>
                                    <option value="other_expense" {{ old('category') === 'other_expense' ? 'selected' : '' }}>Other Expense</option>
                                </optgroup>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" required />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Transaction Date -->
                        <div class="mb-4">
                            <x-input-label for="transaction_date" :value="__('Transaction Date')" />
                            <x-text-input id="transaction_date" class="block mt-1 w-full" type="date" name="transaction_date" :value="old('transaction_date', date('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Cancel
                            </a>
                            <x-primary-button class="ml-4">
                                {{ __('Add Transaction') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('type').addEventListener('change', function() {
            const incomeCategories = document.getElementById('income-categories');
            const expenseCategories = document.getElementById('expense-categories');
            const categorySelect = document.getElementById('category');
            
            // Reset category selection
            categorySelect.value = '';
            
            if (this.value === 'income') {
                incomeCategories.style.display = 'block';
                expenseCategories.style.display = 'none';
            } else if (this.value === 'expense') {
                incomeCategories.style.display = 'none';
                expenseCategories.style.display = 'block';
            } else {
                incomeCategories.style.display = 'none';
                expenseCategories.style.display = 'none';
            }
        });
        
        // Trigger change event on page load to show correct categories
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('type').dispatchEvent(new Event('change'));
        });
    </script>
</x-app-layout>