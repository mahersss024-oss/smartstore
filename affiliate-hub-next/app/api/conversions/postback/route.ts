import { NextRequest, NextResponse } from "next/server";
import { parseConversionPostback, recordConversion } from "@/lib/conversions";

function isAuthorized(request: NextRequest): boolean {
  const token = process.env.POSTBACK_SECRET;
  if (!token) return true;

  const provided = request.nextUrl.searchParams.get("token") || request.headers.get("x-postback-token");
  return provided === token;
}

export async function GET(request: NextRequest) {
  if (!isAuthorized(request)) {
    return NextResponse.json({ ok: false, error: "Unauthorized" }, { status: 401 });
  }

  try {
    const conversion = parseConversionPostback(request.nextUrl.searchParams);
    const result = await recordConversion(conversion);
    return NextResponse.json({ ok: true, ...result });
  } catch (error) {
    console.error(error);
    return NextResponse.json({ ok: false, error: "Invalid postback" }, { status: 400 });
  }
}
