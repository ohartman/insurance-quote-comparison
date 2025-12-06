import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import type { Quote, QuoteFilters, Provider } from '../types';

export const useQuoteStore = defineStore('quotes', () => {
  const quotes = ref<Quote[]>([]);
  const providers = ref<Provider[]>([]);
  const loading = ref(false);
  const error = ref<string | null>(null);
  const filters = ref<QuoteFilters>({});

  const filteredQuotes = computed(() => {
    return quotes.value;
  });

  const sortedQuotes = computed(() => {
    return [...filteredQuotes.value].sort((a, b) => 
      parseFloat(a.monthly_premium) - parseFloat(b.monthly_premium)
    );
  });

  async function fetchQuotes(filterParams?: QuoteFilters) {
    loading.value = true;
    error.value = null;
    
    try {
      const params = new URLSearchParams();
      if (filterParams?.coverage_type) params.append('coverage_type', filterParams.coverage_type);
      if (filterParams?.min_premium) params.append('min_premium', filterParams.min_premium.toString());
      if (filterParams?.max_premium) params.append('max_premium', filterParams.max_premium.toString());
      if (filterParams?.provider_id) params.append('provider_id', filterParams.provider_id.toString());

      const response = await fetch(`/api/quotes?${params}`);
      if (!response.ok) throw new Error('Failed to fetch quotes');
      
      const data = await response.json();
      quotes.value = data.data;
    } catch (e) {
      error.value = e instanceof Error ? e.message : 'An error occurred';
    } finally {
      loading.value = false;
    }
  }

  async function fetchProviders() {
    try {
      const response = await fetch('/api/providers');
      if (!response.ok) throw new Error('Failed to fetch providers');
      
      const data = await response.json();
      providers.value = data.data;
    } catch (e) {
      console.error('Error fetching providers:', e);
    }
  }

  async function createQuote(quoteData: any) {
    loading.value = true;
    error.value = null;

    try {
      const response = await fetch('/api/quotes', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(quoteData),
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || 'Failed to create quote');
      }

      const data = await response.json();
      quotes.value.unshift(data.data);
      return data.data;
    } catch (e) {
      error.value = e instanceof Error ? e.message : 'An error occurred';
      throw e;
    } finally {
      loading.value = false;
    }
  }

  async function deleteQuote(id: number) {
    try {
      const response = await fetch(`/api/quotes/${id}`, {
        method: 'DELETE',
      });

      if (!response.ok) throw new Error('Failed to delete quote');
      
      quotes.value = quotes.value.filter(q => q.id !== id);
    } catch (e) {
      error.value = e instanceof Error ? e.message : 'An error occurred';
      throw e;
    }
  }

  function setFilters(newFilters: QuoteFilters) {
    filters.value = newFilters;
    fetchQuotes(newFilters);
  }

  return {
    quotes,
    providers,
    loading,
    error,
    filters,
    filteredQuotes,
    sortedQuotes,
    fetchQuotes,
    fetchProviders,
    createQuote,
    deleteQuote,
    setFilters,
  };
});
