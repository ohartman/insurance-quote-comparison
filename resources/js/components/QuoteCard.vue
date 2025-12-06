<template>
  <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
    <div class="flex justify-between items-start mb-4">
      <div>
        <h3 class="text-xl font-bold text-gray-900">{{ quote.provider.name }}</h3>
        <div class="flex items-center mt-1">
          <span class="text-yellow-500">★</span>
          <span class="ml-1 text-sm text-gray-600">{{ quote.provider.rating }}</span>
        </div>
      </div>
      <span 
        class="px-3 py-1 rounded-full text-xs font-semibold"
        :class="coverageTypeClass"
      >
        {{ formatCoverageType(quote.coverage_type) }}
      </span>
    </div>

    <div class="space-y-3 mb-4">
      <div class="flex justify-between">
        <span class="text-gray-600">Monthly Premium:</span>
        <span class="font-semibold text-gray-900">${{ quote.monthly_premium }}</span>
      </div>
      <div class="flex justify-between">
        <span class="text-gray-600">Annual Premium:</span>
        <span class="font-semibold text-gray-900">${{ quote.annual_premium }}</span>
      </div>
      <div class="flex justify-between">
        <span class="text-gray-600">Deductible:</span>
        <span class="font-semibold text-gray-900">${{ quote.deductible }}</span>
      </div>
      <div class="flex justify-between">
        <span class="text-gray-600">Coverage Limit:</span>
        <span class="font-semibold text-gray-900">${{ quote.coverage_limit }}</span>
      </div>
      <div class="border-t pt-3 flex justify-between">
        <span class="text-gray-900 font-medium">Total Annual Cost:</span>
        <span class="font-bold text-lg text-blue-600">${{ quote.total_cost }}</span>
      </div>
    </div>

    <div class="text-sm text-gray-500 mb-4">
      <p>{{ quote.vehicle.year }} {{ quote.vehicle.make }} {{ quote.vehicle.model }}</p>
      <p>{{ quote.customer.name }}</p>
    </div>

    <div class="flex gap-2">
      <button
        @click="$emit('select', quote)"
        class="flex-1 bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors"
      >
        Select Quote
      </button>
      <button
        @click="$emit('delete', quote.id)"
        class="px-4 py-2 text-red-600 hover:bg-red-50 rounded transition-colors"
      >
        Delete
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import type { Quote } from '../types';

const props = defineProps<{
  quote: Quote;
}>();

defineEmits<{
  select: [quote: Quote];
  delete: [id: number];
}>();

const coverageTypeClass = computed(() => {
  const classes = {
    liability: 'bg-blue-100 text-blue-800',
    collision: 'bg-green-100 text-green-800',
    comprehensive: 'bg-purple-100 text-purple-800',
    full: 'bg-red-100 text-red-800',
  };
  return classes[props.quote.coverage_type];
});

function formatCoverageType(type: string): string {
  return type.charAt(0).toUpperCase() + type.slice(1);
}
</script>
