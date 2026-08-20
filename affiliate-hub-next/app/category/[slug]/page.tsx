import { notFound } from "next/navigation";
import { ProductSearchClient } from "@/components/ProductSearchClient";
import { categories, getCategoryBySlug } from "@/lib/categories";
import { getInitialMarketingCopy } from "@/lib/marketing-context";
import { paginateProducts } from "@/lib/product-pagination";
import { rankProductOptions, recognizeProductIntent } from "@/lib/product-intelligence";
import { getProducts } from "@/lib/products";

type Props = {
  params: Promise<{ slug: string }>;
};

export function generateStaticParams() {
  return categories.map((category) => ({ slug: category.slug }));
}

export async function generateMetadata({ params }: Props) {
  const { slug } = await params;
  const category = getCategoryBySlug(slug);

  if (!category) return { title: "التصنيف غير موجود" };

  return {
    title: `${category.name} | أفضل العروض`,
    description: category.description,
  };
}

export default async function CategoryPage({ params }: Props) {
  const { slug } = await params;
  const category = getCategoryBySlug(slug);
  if (!category) notFound();

  const rawProducts = await getProducts(category.query);
  const rankedProducts = rankProductOptions(rawProducts, category.query);
  const recognition = recognizeProductIntent(category.query, rankedProducts);
  const initialMarketingCopy = await getInitialMarketingCopy(category.query, rankedProducts);
  const paginated = paginateProducts(rankedProducts);

  return (
    <ProductSearchClient
      initialProducts={paginated.products}
      initialRecognition={recognition}
      initialQuery={category.query}
      initialMarketingCopy={initialMarketingCopy}
      initialPage={paginated.page}
      initialPageSize={paginated.pageSize}
      initialTotal={paginated.total}
      initialHasMore={paginated.hasMore}
    />
  );
}
