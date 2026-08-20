import { generateMarketingCopy } from "@/lib/marketing";
import { PRODUCT_PAGE_SIZE } from "@/lib/product-pagination";
import type { RankedProduct } from "@/lib/types";

export function toMarketingProductContext(products: RankedProduct[]) {
  return products.slice(0, PRODUCT_PAGE_SIZE).map((product) => ({
    title: product.title,
    price: product.price,
    currency: product.currency,
    discountPercent: product.discountPercent,
    storeName: product.storeName,
    merchantReliabilityScore: product.merchantReliabilityScore,
    merchantCustomerRating: product.merchantCustomerRating,
    comparisonReason: product.insight.whyThisOption,
  }));
}

export async function getInitialMarketingCopy(query: string, products: RankedProduct[]) {
  const searchTerm = query.trim();
  if (!searchTerm) return undefined;

  try {
    return await generateMarketingCopy(searchTerm, toMarketingProductContext(products));
  } catch (error) {
    console.error(error);
    return undefined;
  }
}
