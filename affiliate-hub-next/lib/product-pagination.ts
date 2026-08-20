import type { RankedProduct } from "@/lib/types";

export const PRODUCT_PAGE_SIZE = 24;
export const MAX_PRODUCT_PAGE_SIZE = 48;

export function normalizeProductPage(value: string | null): number {
  const page = Number(value);
  if (!Number.isFinite(page) || page < 1) return 1;
  return Math.floor(page);
}

export function normalizeProductPageSize(value: string | null): number {
  const pageSize = Number(value);
  if (!Number.isFinite(pageSize) || pageSize < 1) return PRODUCT_PAGE_SIZE;
  return Math.min(MAX_PRODUCT_PAGE_SIZE, Math.floor(pageSize));
}

export function paginateProducts(products: RankedProduct[], page = 1, pageSize = PRODUCT_PAGE_SIZE) {
  const currentPage = Math.max(1, Math.floor(page));
  const safePageSize = Math.min(MAX_PRODUCT_PAGE_SIZE, Math.max(1, Math.floor(pageSize)));
  const start = (currentPage - 1) * safePageSize;
  const paginatedProducts = products.slice(start, start + safePageSize);

  return {
    products: paginatedProducts,
    page: currentPage,
    pageSize: safePageSize,
    total: products.length,
    hasMore: start + paginatedProducts.length < products.length,
  };
}
