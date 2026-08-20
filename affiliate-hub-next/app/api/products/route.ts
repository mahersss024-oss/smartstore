import { NextRequest, NextResponse } from "next/server";
import { normalizeProductPage, normalizeProductPageSize, paginateProducts } from "@/lib/product-pagination";
import { rankProductOptions, recognizeProductIntent } from "@/lib/product-intelligence";
import { getProducts } from "@/lib/products";

export async function GET(request: NextRequest) {
  const query = request.nextUrl.searchParams.get("q") ?? "";
  const page = normalizeProductPage(request.nextUrl.searchParams.get("page"));
  const pageSize = normalizeProductPageSize(request.nextUrl.searchParams.get("pageSize"));
  const rawProducts = await getProducts(query);
  const rankedProducts = rankProductOptions(rawProducts, query);
  const recognition = recognizeProductIntent(query, rankedProducts);
  const paginated = paginateProducts(rankedProducts, page, pageSize);

  return NextResponse.json(
    { recognition, ...paginated },
    {
      headers: {
        "Cache-Control": query ? "no-store" : "s-maxage=300, stale-while-revalidate=600",
      },
    }
  );
}
