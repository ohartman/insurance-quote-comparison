export interface Provider {
  id: number;
  name: string;
  rating: string;
  phone: string;
  website: string;
  quotes_count?: number;
}

export interface Quote {
  id: number;
  provider: Provider;
  coverage_type: 'liability' | 'collision' | 'comprehensive' | 'full';
  monthly_premium: string;
  annual_premium: string;
  deductible: string;
  coverage_limit: string;
  total_cost: string;
  customer: {
    name: string;
    email: string;
  };
  vehicle: {
    year: number;
    make: string;
    model: string;
  };
  created_at: string;
  updated_at: string;
}

export interface QuoteFormData {
  provider_id: number;
  coverage_type: string;
  monthly_premium: number;
  deductible: number;
  coverage_limit: number;
  customer_name: string;
  customer_email: string;
  vehicle_year: number;
  vehicle_make: string;
  vehicle_model: string;
}

export interface QuoteFilters {
  coverage_type?: string;
  min_premium?: number;
  max_premium?: number;
  provider_id?: number;
}
