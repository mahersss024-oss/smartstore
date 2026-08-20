import type { MetadataRoute } from "next";
import { categories } from "@/lib/categories";
import { getProducts } from "@/lib/products";
import { buildDealTargets } from "@/lib/seo-deals";
import { getSiteUrl } from "@/lib/site-url";

export default async function sitemap(): Promise<MetadataRoute.Sitemap> {
  const products = await getProducts();
  const origin = getSiteUrl();

  return [
    {
      url: origin,
      lastModified: new Date(),
      changeFrequency: "daily",
      priority: 1,
    },
    ...products.map((product) => ({
      url: `${origin}/product/${product.id}`,
      lastModified: new Date(),
      changeFrequency: "daily" as const,
      priority: 0.8,
    })),
    ...categories.map((category) => ({
      url: `${origin}/category/${category.slug}`,
      lastModified: new Date(),
      changeFrequency: "daily" as const,
      priority: 0.7,
    })),
    ...buildDealTargets(products).map((target) => ({
      url: `${origin}/deals/${target.slug}`,
      lastModified: new Date(),
      changeFrequency: "daily" as const,
      priority: 0.75,
    })),
  ];
}
