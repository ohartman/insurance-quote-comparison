<template>
  <div class="min-h-screen bg-gray-50">
    <header class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-3xl font-bold text-gray-900">Insurance Quote Comparison</h1>
        <p class="text-gray-600 mt-1">Compare quotes from top providers</p>
      </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-8">
        <!-- Quote Form -->
        <QuoteForm
          :providers="quoteStore.providers"
          :loading="quoteStore.loading"
          :error="quoteStore.error"
          @submit="handleCreateQuote"
        />

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-md p-6">
          <h2 class="text-xl font-bold mb-4">Filter Quotes</h2>
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Coverage Type
              </label>
              <select
                v-model="filters.coverage_type"
                @change="applyFilters"
                class="w-full px-3 py-2 border border-gray-300 rounded-md"
              >
                <option value="">All Types</option>
                <option value="liability">Liability</option>
                <option value="collision">Collision</option>
                <option value="comprehensive">Comprehensive</option>
                <option value="full">Full Coverage</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Provider
              </label>
              <select
                v-model="filters.provider_id"
                @change="applyFilters"
                class="w-full px-3 py-2 border border-gray-300 rounded-md"
              >
                <option value="">All Providers</option>
                <option v-for="provider in quoteStore.providers" :key="provider.id" :value="provider.id">
                  {{ provider.name }}
                </option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Min Premium ($)
              </label>
              <input
                v-model.number="filters.min_premium"
                @input="applyFilters"
                type="number"
                placeholder="0"
                class="w-full px-3 py-2 border border-gray-300 rounded-md"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                Max Premium ($)
              </label>
              <input
                v-model.number="filters.max_premium"
                @input="applyFilters"
                type="number"
                placeholder="1000"
                class="w-full px-3 py-2 border border-gray-300 rounded-md"
              />
            </div>
          </div>
          <button
            @click="clearFilters"
            class="mt-4 text-blue-600 hover:text-blue-800 text-sm font-medium"
          >
            Clear Filters
          </button>
        </div>

        <!-- Quote List -->
        <div>
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Available Quotes ({{ quoteStore.sortedQuotes.length }})</h2>
          </div>

          <div v-if="quoteStore.loading" class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-blue-600 border-t-transparent"></div>
            <p class="mt-4 text-gray-600">Loading quotes...</p>
          </div>

          <div v-else-if="quoteStore.sortedQuotes.length === 0" class="text-center py-12 bg-white rounded-lg">
            <p class="text-gray-600">No quotes found. Try adjusting your filters or create a new quote.</p>
          </div>

          <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <QuoteCard
              v-for="quote in quoteStore.sortedQuotes"
              :key="quote.id"
              :quote="quote"
              @select="selectQuote"
              @delete="handleDeleteQuote"
            />
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { onMounted, reactive } from 'vue';
import { useQuoteStore } from './stores/quoteStore';
import QuoteCard from './components/QuoteCard.vue';
import QuoteForm from './components/QuoteForm.vue';
import type { Quote, QuoteFormData, QuoteFilters } from './types';

const quoteStore = useQuoteStore();

const filters = reactive<QuoteFilters>({
  coverage_type: '',
  provider_id: undefined,
  min_premium: undefined,
  max_premium: undefined,
});

onMounted(async () => {
  await quoteStore.fetchProviders();
  await quoteStore.fetchQuotes();
});

async function handleCreateQuote(data: QuoteFormData) {
  try {
    await quoteStore.createQuote(data);
    alert('Quote created successfully!');
  } catch (error) {
    console.error('Failed to create quote:', error);
  }
}

async function handleDeleteQuote(id: number) {
  if (confirm('Are you sure you want to delete this quote?')) {
    try {
      await quoteStore.deleteQuote(id);
    } catch (error) {
      console.error('Failed to delete quote:', error);
    }
  }
}

function selectQuote(quote: Quote) {
  alert(`Selected: ${quote.provider.name} - $${quote.monthly_premium}/month`);
}

function applyFilters() {
  const cleanFilters: QuoteFilters = {};
  if (filters.coverage_type) cleanFilters.coverage_type = filters.coverage_type;
  if (filters.provider_id) cleanFilters.provider_id = Number(filters.provider_id);
  if (filters.min_premium) cleanFilters.min_premium = filters.min_premium;
  if (filters.max_premium) cleanFilters.max_premium = filters.max_premium;
  
  quoteStore.setFilters(cleanFilters);
}

function clearFilters() {
  filters.coverage_type = '';
  filters.provider_id = undefined;
  filters.min_premium = undefined;
  filters.max_premium = undefined;
  quoteStore.setFilters({});
}
</script>
