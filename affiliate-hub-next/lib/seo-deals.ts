import type { Product } from "@/lib/types";

export function toDealSlug(value: string): string {
  return value
    .trim()
    .toLowerCase()
    .normalize("NFKD")
    .replace(/[\u0300-\u036f]/g, "")
    .replace(/&/g, " and ")
    .replace(/[^\p{L}\p{N}]+/gu, "-")
    .replace(/^-+|-+$/g, "")
    .slice(0, 96);
}

export function queryFromDealSlug(slug: string): string {
  return decodeURIComponent(slug)
    .replace(/-/g, " ")
    .replace(/\s+/g, " ")
    .trim();
}

export function buildDealTargets(products: Product[]): Array<{ slug: string; query: string; title: string }> {
  const targets = new Map<string, { slug: string; query: string; title: string }>();

  for (const product of products) {
    const productSlug = toDealSlug(product.title);
    if (productSlug) {
      targets.set(productSlug, {
        slug: productSlug,
        query: product.title,
        title: product.title,
      });
    }

    const categorySlug = toDealSlug(product.category);
    if (categorySlug && !targets.has(categorySlug)) {
      targets.set(categorySlug, {
        slug: categorySlug,
        query: product.category,
        title: product.category,
      });
    }
  }

  return [...targets.values()];
}
