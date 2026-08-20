import type { Metadata } from "next";
import { notFound } from "next/navigation";
import { CheckoutProductDetail } from "@/components/CheckoutProductDetail";
import { getProductById, getProducts } from "@/lib/products";

type Props = {
  params: {
    id: string;
  };
};

export async function generateStaticParams() {
  const products = await getProducts();
  return products.map((product) => ({ id: product.id }));
}

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const product = await getProductById(params.id);

  if (!product) {
    return {
      title: "Product not found",
    };
  }

  return {
    title: product.title,
    description: product.description,
    openGraph: {
      title: product.title,
      description: product.description,
      images: [product.image],
      type: "website",
    },
  };
}

export default async function ProductPage({ params }: Props) {
  const product = await getProductById(params.id);
  if (!product) notFound();

  const jsonLd = {
    "@context": "https://schema.org",
    "@type": "Product",
    name: product.title,
    description: product.description,
    image: product.image,
    brand: {
      "@type": "Brand",
      name: product.merchant,
    },
    aggregateRating: {
      "@type": "AggregateRating",
      ratingValue: product.rating,
      reviewCount: Math.max(8, product.soldLastHour),
    },
    offers: {
      "@type": "Offer",
      url: `/product/${product.id}`,
      priceCurrency: product.currency,
      price: product.price,
      availability: `https://schema.org/${product.availability}`,
    },
  };

  return (
    <>
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(jsonLd) }}
      />
      <CheckoutProductDetail product={product} />
    </>
  );
}
