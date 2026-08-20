import type { Metadata } from "next";
import { ProductSearchClient } from "@/components/ProductSearchClient";
import { getInitialMarketingCopy } from "@/lib/marketing-context";
import { paginateProducts } from "@/lib/product-pagination";
import { rankProductOptions, recognizeProductIntent } from "@/lib/product-intelligence";
import { getProducts } from "@/lib/products";
import { buildDealTargets, queryFromDealSlug } from "@/lib/seo-deals";
import { absoluteUrl } from "@/lib/site-url";

export const dynamic = "force-dynamic";

type Props = {
  params: Promise<{ slug: string }>;
};

export async function generateStaticParams() {
  const products = await getProducts();
  return buildDealTargets(products)
    .slice(0, 500)
    .map((target) => ({ slug: target.slug }));
}

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { slug } = await params;
  const query = queryFromDealSlug(slug);
  const title = query ? `أفضل عروض ${query} اليوم` : "أفضل العروض اليوم";
  const description = query
    ? `قارن أسعار ${query} من متاجر موثوقة، وشاهد أفضل الخيارات حسب السعر وتقييم العملاء وموثوقية التاجر.`
    : "قارن أفضل العروض المتاحة من متاجر موثوقة حسب السعر والتقييم وموثوقية التاجر.";

  return {
    title,
    description,
    alternates: {
      canonical: `/deals/${slug}`,
    },
    openGraph: {
      title,
      description,
      type: "website",
      url: absoluteUrl(`/deals/${slug}`),
    },
  };
}

export default async function DealPage({ params }: Props) {
  const { slug } = await params;
  const query = queryFromDealSlug(slug);
  const rawProducts = await getProducts(query);
  const rankedProducts = rankProductOptions(rawProducts, query);
  const recognition = recognizeProductIntent(query, rankedProducts);
  const initialMarketingCopy = await getInitialMarketingCopy(query, rankedProducts);
  const paginated = paginateProducts(rankedProducts);

  const jsonLd = rankedProducts.length
    ? {
        "@context": "https://schema.org",
        "@type": "ItemList",
        name: `أفضل عروض ${query}`,
        description: `خيارات مقارنة مختارة حول ${query}`,
        numberOfItems: rankedProducts.length,
        itemListElement: rankedProducts.slice(0, 12).map((product, index) => ({
          "@type": "ListItem",
          position: index + 1,
          url: absoluteUrl(`/product/${product.id}`),
          item: {
            "@type": "Product",
            name: product.title,
            description: product.description,
            image: product.image,
            aggregateRating: {
              "@type": "AggregateRating",
              ratingValue: product.rating,
              reviewCount: product.merchantReviewCount,
            },
            offers: {
              "@type": "Offer",
              price: product.price,
              priceCurrency: product.currency,
              availability: `https://schema.org/${product.availability}`,
              seller: {
                "@type": "Organization",
                name: product.storeName,
              },
            },
          },
        })),
      }
    : null;

  return (
    <>
      {jsonLd ? (
        <script
          type="application/ld+json"
          dangerouslySetInnerHTML={{ __html: JSON.stringify(jsonLd) }}
        />
      ) : null}
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
    </>
  );
}
