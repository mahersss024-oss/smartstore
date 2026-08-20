import { NextRequest, NextResponse } from "next/server";
import { generateMarketingCopy } from "@/lib/marketing";

export async function POST(request: NextRequest) {
  try {
    const body = await request.json();
    const query = typeof body?.query === "string" ? body.query : "";
    const products = Array.isArray(body?.products) ? body.products : [];
    const copy = await generateMarketingCopy(query, products);

    return NextResponse.json({ copy });
  } catch (error) {
    console.error(error);
    return NextResponse.json(
      {
        copy: "هذا العرض يشهد طلبًا مرتفعًا الآن، اغتنم السعر الحالي قبل تغيّر الكمية أو انتهاء الخصم.",
      },
      { status: 200 }
    );
  }
}
