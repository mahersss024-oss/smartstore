import { ProductSearchClient } from "@/components/ProductSearchClient";
import { getInitialMarketingCopy } from "@/lib/marketing-context";
import { paginateProducts } from "@/lib/product-pagination";
import { rankProductOptions, recognizeProductIntent } from "@/lib/product-intelligence";
import { getProducts } from "@/lib/products";

type Props = {
  searchParams?: Promise<{
    q?: string | string[];
  }>;
};

function getQuery(value?: string | string[]) {
  if (Array.isArray(value)) return value[0]?.trim() ?? "";
  return value?.trim() ?? "";
}

export default async function HomePage({ searchParams }: Props) {
  const params = searchParams ? await searchParams : {};
  const query = getQuery(params.q);
  const rawProducts = await getProducts(query);
  const rankedProducts = rankProductOptions(rawProducts, query);
  const recognition = recognizeProductIntent(query, rankedProducts);
  const initialMarketingCopy = await getInitialMarketingCopy(query, rankedProducts);
  const paginated = paginateProducts(rankedProducts);

  return (
    <ProductSearchClient
      initialProducts={paginated.products}
      initialRecognition={recognition}
      initialQuery={query}
      initialMarketingCopy={initialMarketingCopy}
      initialPage={paginated.page}
      initialPageSize={paginated.pageSize}
      initialTotal={paginated.total}
      initialHasMore={paginated.hasMore}
    />
  );
}
