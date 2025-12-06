<template>
  <div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6">Get a New Quote</h2>
    
    <form @submit.prevent="handleSubmit" class="space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Insurance Provider
          </label>
          <select
            v-model="form.provider_id"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="">Select Provider</option>
            <option v-for="provider in providers" :key="provider.id" :value="provider.id">
              {{ provider.name }} ({{ provider.rating }}★)
            </option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Coverage Type
          </label>
          <select
            v-model="form.coverage_type"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="">Select Coverage</option>
            <option value="liability">Liability</option>
            <option value="collision">Collision</option>
            <option value="comprehensive">Comprehensive</option>
            <option value="full">Full Coverage</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Monthly Premium ($)
          </label>
          <input
            v-model.number="form.monthly_premium"
            type="number"
            step="0.01"
            required
            min="0"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Deductible ($)
          </label>
          <select
            v-model.number="form.deductible"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="500">$500</option>
            <option value="1000">$1,000</option>
            <option value="2000">$2,000</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Coverage Limit ($)
          </label>
          <select
            v-model.number="form.coverage_limit"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="50000">$50,000</option>
            <option value="100000">$100,000</option>
            <option value="250000">$250,000</option>
            <option value="500000">$500,000</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Customer Name
          </label>
          <input
            v-model="form.customer_name"
            type="text"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Email
          </label>
          <input
            v-model="form.customer_email"
            type="email"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Vehicle Year
          </label>
          <input
            v-model.number="form.vehicle_year"
            type="number"
            required
            :min="1900"
            :max="new Date().getFullYear() + 1"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Vehicle Make
          </label>
          <input
            v-model="form.vehicle_make"
            type="text"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Vehicle Model
          </label>
          <input
            v-model="form.vehicle_model"
            type="text"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
          />
        </div>
      </div>

      <div class="flex gap-4 pt-4">
        <button
          type="submit"
          :disabled="loading"
          class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-md hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors font-medium"
        >
          {{ loading ? 'Creating...' : 'Get Quote' }}
        </button>
        <button
          type="button"
          @click="resetForm"
          class="px-6 py-3 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
        >
          Reset
        </button>
      </div>

      <div v-if="error" class="text-red-600 text-sm mt-2">
        {{ error }}
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue';
import type { Provider, QuoteFormData } from '../types';

const props = defineProps<{
  providers: Provider[];
  loading: boolean;
  error: string | null;
}>();

const emit = defineEmits<{
  submit: [data: QuoteFormData];
}>();

const form = reactive<QuoteFormData>({
  provider_id: 0,
  coverage_type: '',
  monthly_premium: 0,
  deductible: 1000,
  coverage_limit: 100000,
  customer_name: '',
  customer_email: '',
  vehicle_year: new Date().getFullYear(),
  vehicle_make: '',
  vehicle_model: '',
});

function handleSubmit() {
  emit('submit', { ...form });
}

function resetForm() {
  form.provider_id = 0;
  form.coverage_type = '';
  form.monthly_premium = 0;
  form.deductible = 1000;
  form.coverage_limit = 100000;
  form.customer_name = '';
  form.customer_email = '';
  form.vehicle_year = new Date().getFullYear();
  form.vehicle_make = '';
  form.vehicle_model = '';
}
</script>
