import { NextRequest, NextResponse } from "next/server";
import { getProductById } from "@/lib/products";
import { appendTrackingToAffiliateUrl, createClickEvent, createClickId, recordClick } from "@/lib/tracking";

type RouteContext = {
  params: Promise<{
    productId: string;
  }>;
};

export async function GET(request: NextRequest, context: RouteContext) {
  const { productId } = await context.params;
  const product = await getProductById(decodeURIComponent(productId));

  if (!product) {
    return NextResponse.redirect(new URL("/", request.url), 302);
  }

  const clickId = createClickId(product.id);
  const destinationUrl = appendTrackingToAffiliateUrl(product.affiliateUrl, clickId);
  const event = createClickEvent(request, product, clickId, destinationUrl);

  await recordClick(event);

  return NextResponse.redirect(destinationUrl, 302);
}
