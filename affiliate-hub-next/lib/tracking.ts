import type { NextRequest } from "next/server";
import { prisma } from "@/lib/db";
import type { ClickTrackingEvent, Product } from "@/lib/types";

function safeParam(value: string | null, fallback: string): string {
  const text = value?.trim();
  return text || fallback;
}

export function createClickId(productId: string): string {
  const random = crypto.randomUUID().slice(0, 8);
  return `${productId}-${Date.now()}-${random}`;
}

export function appendTrackingToAffiliateUrl(destinationUrl: string, clickId: string): string {
  const subIdParam = process.env.AFFILIATE_SUBID_PARAM || "subid";

  try {
    const url = new URL(destinationUrl);
    url.searchParams.set(subIdParam, clickId);
    return url.toString();
  } catch {
    return destinationUrl;
  }
}

export function createClickEvent(request: NextRequest, product: Product, clickId: string, destinationUrl: string): ClickTrackingEvent {
  const params = request.nextUrl.searchParams;

  return {
    clickId,
    productId: product.id,
    productTitle: product.title,
    storeName: product.storeName,
    merchantName: product.merchantName,
    source: safeParam(params.get("source"), "site"),
    campaign: safeParam(params.get("campaign"), "default"),
    searchQuery: safeParam(params.get("q"), ""),
    destinationUrl,
    createdAt: new Date().toISOString(),
  };
}

export async function recordClick(event: ClickTrackingEvent): Promise<void> {
  console.info("affiliate_click", JSON.stringify(event));

  if (!process.env.DATABASE_URL) return;

  try {
    await prisma.affiliateClick.create({
      data: event,
    });
  } catch (error) {
    console.error("affiliate_click_database_error", error);
  }
}
