import { prisma } from "@/lib/db";
import type { ConversionPostback } from "@/lib/types";

function asNumber(value: string | null, fallback = 0): number {
  if (!value) return fallback;
  const parsed = Number(value.replace(/[^\d.-]/g, ""));
  return Number.isFinite(parsed) ? parsed : fallback;
}

function normalizeStatus(value: string | null): ConversionPostback["status"] {
  const status = value?.trim().toLowerCase();
  if (status === "approved" || status === "confirmed" || status === "success") return "approved";
  if (status === "rejected" || status === "declined" || status === "cancelled") return "rejected";
  if (status === "paid" || status === "settled") return "paid";
  return "pending";
}

export function parseConversionPostback(params: URLSearchParams): ConversionPostback {
  const rawPayload = Object.fromEntries(params.entries());

  return {
    clickId: params.get("click_id") || params.get("clickId") || params.get("subid") || params.get("sub_id") || "",
    network: params.get("network") || params.get("affiliate_network") || "affiliate",
    orderId: params.get("order_id") || params.get("orderId") || params.get("transaction_id") || crypto.randomUUID(),
    orderValue: asNumber(params.get("order_value") || params.get("sale_amount") || params.get("amount")),
    commissionValue: asNumber(params.get("commission") || params.get("commission_value") || params.get("payout")),
    currency: params.get("currency") || "USD",
    status: normalizeStatus(params.get("status")),
    rawPayload,
  };
}

export async function recordConversion(conversion: ConversionPostback) {
  console.info("affiliate_conversion", JSON.stringify(conversion));

  if (!conversion.clickId) {
    throw new Error("Missing click id");
  }

  if (!process.env.DATABASE_URL) {
    return { stored: false, reason: "DATABASE_URL is not configured" };
  }

  const saved = await prisma.affiliateConversion.upsert({
    where: {
      network_orderId: {
        network: conversion.network,
        orderId: conversion.orderId,
      },
    },
    update: {
      clickId: conversion.clickId,
      orderValue: conversion.orderValue,
      commissionValue: conversion.commissionValue,
      currency: conversion.currency,
      status: conversion.status,
      rawPayload: conversion.rawPayload,
    },
    create: conversion,
  });

  return { stored: true, conversion: saved };
}
