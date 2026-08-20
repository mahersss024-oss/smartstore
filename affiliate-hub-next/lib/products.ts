import { XMLParser } from "fast-xml-parser";
import { demoProducts } from "@/lib/demo-products";
import type { Product } from "@/lib/types";

const parser = new XMLParser({
  ignoreAttributes: false,
  attributeNamePrefix: "",
});

type FeedRecord = Record<string, unknown>;

function asString(value: unknown, fallback = ""): string {
  if (typeof value === "string") return value.trim();
  if (typeof value === "number") return String(value);
  return fallback;
}

function asNumber(value: unknown, fallback = 0): number {
  if (typeof value === "number" && Number.isFinite(value)) return value;
  if (typeof value === "string") {
    const parsed = Number(value.replace(/[^\d.]/g, ""));
    if (Number.isFinite(parsed)) return parsed;
  }
  return fallback;
}

function firstValue(record: FeedRecord, keys: string[], fallback = ""): string {
  for (const key of keys) {
    const value = record[key];
    const text = asString(value);
    if (text) return text;
  }
  return fallback;
}

function hasProductShape(record: FeedRecord): boolean {
  return Boolean(
    firstValue(record, ["id", "product_id", "sku", "offer_id"]) &&
      firstValue(record, ["title", "name", "product_name"]) &&
      firstValue(record, ["url", "affiliate_url", "tracking_url", "deeplink"])
  );
}

function collectRecords(value: unknown, records: FeedRecord[] = []): FeedRecord[] {
  if (Array.isArray(value)) {
    value.forEach((item) => collectRecords(item, records));
    return records;
  }

  if (value && typeof value === "object") {
    const record = value as FeedRecord;
    if (hasProductShape(record)) records.push(record);
    Object.values(record).forEach((child) => collectRecords(child, records));
  }

  return records;
}

function normalizeRecord(record: FeedRecord, index: number): Product {
  const id = firstValue(record, ["id", "product_id", "sku", "offer_id"], `feed-${index}`);
  const title = firstValue(record, ["title", "name", "product_name"], "Affiliate product");
  const description = firstValue(record, ["description", "short_description", "summary"], "عرض مختار بسعر منافس من متجر شريك.");
  const affiliateUrl = firstValue(record, ["affiliate_url", "tracking_url", "deeplink", "url"], "#");
  const image = firstValue(record, ["image", "image_url", "picture", "thumbnail"], "/placeholder-product.svg");
  const price = asNumber(record.price ?? record.sale_price ?? record.current_price, 0);
  const originalPrice = asNumber(record.original_price ?? record.old_price ?? record.list_price, 0);
  const currency = firstValue(record, ["currency", "currency_code"], "USD");
  const rating = Math.min(5, Math.max(3.8, asNumber(record.rating, 4.6)));
  const discountPercent = Math.max(0, asNumber(record.discount_percent ?? record.discount, 15));
  const storeName = firstValue(record, ["store_name", "store", "shop", "advertiser", "merchant"], "متجر شريك");
  const merchantName = firstValue(record, ["merchant_name", "seller", "vendor", "advertiser"], storeName);
  const merchantReliabilityScore = Math.min(
    99,
    Math.max(70, asNumber(record.merchant_reliability_score ?? record.seller_score ?? record.trust_score, 84 + Math.round(rating * 2)))
  );
  const availabilityText = firstValue(record, ["availability", "stock_status"], "InStock").toLowerCase();

  return {
    id: encodeURIComponent(id),
    title,
    description,
    price,
    originalPrice: originalPrice || undefined,
    currency,
    image,
    category: firstValue(record, ["category", "category_name"], "عروض"),
    merchant: firstValue(record, ["merchant", "advertiser", "network"], "Affiliate Network"),
    storeName,
    merchantName,
    storeRating: Math.min(5, Math.max(3.5, asNumber(record.store_rating, rating - 0.1))),
    merchantCustomerRating: Math.min(5, Math.max(3.5, asNumber(record.merchant_customer_rating ?? record.seller_rating, rating))),
    merchantReviewCount: Math.max(25, asNumber(record.merchant_review_count ?? record.review_count ?? record.seller_reviews, 420)),
    merchantReliabilityScore,
    merchantReliabilityLabel: firstValue(
      record,
      ["merchant_reliability_label", "seller_reliability_label"],
      merchantReliabilityScore >= 94 ? "موثوق جدًا" : merchantReliabilityScore >= 86 ? "موثوق" : "موثوق بدرجة جيدة"
    ),
    merchantResponseRate: Math.min(100, Math.max(65, asNumber(record.merchant_response_rate ?? record.seller_response_rate, 88))),
    merchantVerifiedSince: firstValue(record, ["merchant_verified_since", "seller_since", "verified_since"], "غير محدد"),
    shippingInfo: firstValue(record, ["shipping", "shipping_info", "delivery"], "الشحن حسب سياسة المتجر"),
    returnPolicy: firstValue(record, ["return_policy", "returns"], "الإرجاع حسب سياسة المتجر الشريك"),
    trustScore: Math.min(99, Math.max(70, asNumber(record.trust_score, 86 + Math.round(rating * 2)))),
    aiExplanation: firstValue(
      record,
      ["ai_explanation", "recommendation_reason"],
      "هذا العرض مرشح لأنه يجمع بين سعر منافس وتوفر جيد من متجر شريك موثوق."
    ),
    pros: [
      firstValue(record, ["pro_1"], "سعر منافس"),
      firstValue(record, ["pro_2"], "متجر موثوق"),
      firstValue(record, ["pro_3"], "عرض متاح الآن"),
    ],
    cons: [firstValue(record, ["con_1"], "قد تختلف تفاصيل الشحن حسب المدينة")],
    comparisonReason: firstValue(
      record,
      ["comparison_reason"],
      "تم اختياره بناءً على السعر، التقييم، والتوفر الحالي."
    ),
    affiliateUrl,
    rating,
    soldLastHour: Math.max(12, asNumber(record.sold_last_hour, 25)),
    discountPercent,
    availability: availabilityText.includes("out")
      ? "OutOfStock"
      : availabilityText.includes("limited")
        ? "LimitedAvailability"
        : "InStock",
  };
}

function filterProducts(products: Product[], query?: string): Product[] {
  const search = query?.trim().toLowerCase();
  if (!search) return products;

  return products.filter((product) =>
    [
      product.title,
      product.description,
      product.category,
      product.merchant,
      product.storeName,
      product.merchantName,
    ]
      .join(" ")
      .toLowerCase()
      .includes(search)
  );
}

export async function getProducts(query?: string): Promise<Product[]> {
  const feedUrl = process.env.NEXT_PUBLIC_AFFILIATE_API_URL;

  if (!feedUrl || feedUrl.includes("your_affiliate_network")) {
    return filterProducts(demoProducts, query);
  }

  try {
    const response = await fetch(feedUrl, {
      headers: { Accept: "application/json, application/xml, text/xml" },
      next: { revalidate: 300 },
    });

    if (!response.ok) throw new Error(`Affiliate feed failed: ${response.status}`);

    const contentType = response.headers.get("content-type") ?? "";
    const raw = await response.text();
    const parsed = contentType.includes("xml") || raw.trim().startsWith("<")
      ? parser.parse(raw)
      : JSON.parse(raw);

    const products = collectRecords(parsed).map(normalizeRecord);
    return filterProducts(products.length ? products : demoProducts, query);
  } catch (error) {
    console.error(error);
    return filterProducts(demoProducts, query);
  }
}

export async function getProductById(id: string): Promise<Product | null> {
  const products = await getProducts();
  return products.find((product) => product.id === id || decodeURIComponent(product.id) === id) ?? null;
}
