export type Product = {
  id: string;
  title: string;
  description: string;
  price: number;
  originalPrice?: number;
  currency: string;
  image: string;
  category: string;
  merchant: string;
  storeName: string;
  merchantName: string;
  storeRating: number;
  merchantCustomerRating: number;
  merchantReviewCount: number;
  merchantReliabilityScore: number;
  merchantReliabilityLabel: string;
  merchantResponseRate: number;
  merchantVerifiedSince: string;
  shippingInfo: string;
  returnPolicy: string;
  trustScore: number;
  aiExplanation: string;
  pros: string[];
  cons: string[];
  comparisonReason: string;
  affiliateUrl: string;
  rating: number;
  soldLastHour: number;
  discountPercent: number;
  availability: "InStock" | "LimitedAvailability" | "OutOfStock";
};

export type ProductOptionInsight = {
  productId: string;
  rank: number;
  matchScore: number;
  valueScore: number;
  trustScore: number;
  priceScore: number;
  badges: string[];
  bestFor: string;
  whyThisOption: string;
};

export type ProductRecognition = {
  query: string;
  normalizedQuery: string;
  detectedCategory: string;
  detectedIntent: "exact-product" | "category-search" | "deal-search" | "general-search";
  confidence: number;
  summary: string;
  comparedSignals: string[];
};

export type RankedProduct = Product & {
  insight: ProductOptionInsight;
};

export type ProductsApiResponse = {
  recognition: ProductRecognition;
  products: RankedProduct[];
  page: number;
  pageSize: number;
  total: number;
  hasMore: boolean;
};

export type ClickTrackingEvent = {
  clickId: string;
  productId: string;
  productTitle: string;
  storeName: string;
  merchantName: string;
  source: string;
  campaign: string;
  searchQuery: string;
  destinationUrl: string;
  createdAt: string;
};

export type ConversionPostback = {
  clickId: string;
  network: string;
  orderId: string;
  orderValue: number;
  commissionValue: number;
  currency: string;
  status: "pending" | "approved" | "rejected" | "paid";
  rawPayload: Record<string, string>;
};

export type MarketingResponse = {
  copy: string;
};
