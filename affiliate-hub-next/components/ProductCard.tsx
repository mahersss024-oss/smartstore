"use client";

import { BadgeCheck, ChevronLeft, MessageCircle, ShieldCheck, Sparkles, Star, Truck, Users } from "lucide-react";
import Link from "next/link";
import type { Product, RankedProduct } from "@/lib/types";

type Props = {
  product: Product | RankedProduct;
  onBuy: (product: Product) => void;
};

export function ProductCard({ product, onBuy }: Props) {
  const formatter = new Intl.NumberFormat("ar", {
    style: "currency",
    currency: product.currency || "USD",
  });

  return (
    <article className="premium-product-card group relative flex h-full flex-col overflow-hidden rounded-lg bg-white transition hover:-translate-y-0.5 hover:shadow-soft">
      <div className="pointer-events-none absolute inset-0 z-10 opacity-0 transition duration-500 group-hover:opacity-100">
        <div className="h-full w-full bg-[linear-gradient(115deg,transparent_0%,transparent_42%,rgba(255,255,255,0.55)_50%,transparent_58%,transparent_100%)] translate-x-full group-hover:-translate-x-full transition-transform duration-1000" />
      </div>
      <div className="relative aspect-[4/3] overflow-hidden bg-slate-100">
        <img
          src={product.image}
          alt={product.title}
          className="h-full w-full object-cover transition duration-500 group-hover:scale-105"
        />
        <div className="absolute inset-x-3 top-3 flex items-center justify-between gap-2">
          {product.discountPercent > 0 ? (
            <span className="rounded-md bg-[#ff5a5f] px-3 py-1 text-xs font-black text-white shadow-sm">
              خصم {product.discountPercent}%
            </span>
          ) : (
            <span />
          )}
          <span className="flex items-center gap-1 rounded-md bg-white/95 px-2.5 py-1 text-xs font-black text-slate-900 shadow-sm">
            <Star aria-hidden="true" size={14} className="fill-amber-400 text-amber-400" />
            {product.rating.toFixed(1)}
          </span>
        </div>
      </div>

      <div className="flex flex-1 flex-col space-y-4 p-4">
        <div className="flex items-start justify-between gap-3">
          <div className="min-w-0">
            <p className="text-xs font-bold text-[#07515b]">{product.category}</p>
            <h3 className="mt-1 line-clamp-2 min-h-12 text-base font-black leading-6 text-slate-950">
              {product.title}
            </h3>
          </div>
          <div className="trust-chip shrink-0 rounded-md px-2.5 py-1.5 text-center">
            <p className="text-[10px] font-bold">الثقة</p>
            <p className="text-sm font-black">{product.trustScore}%</p>
          </div>
        </div>

        <p className="line-clamp-2 min-h-12 text-sm font-semibold leading-6 text-slate-600">{product.description}</p>

        <div className="rounded-md border border-slate-200 bg-slate-50 p-3">
          <div className="flex items-center justify-between gap-3">
            <div className="min-w-0">
              <p className="truncate text-xs font-bold text-slate-500">{product.storeName}</p>
              <p className="mt-1 truncate text-sm font-black text-slate-950">{product.merchantName}</p>
            </div>
            <span className="flex shrink-0 items-center gap-1 rounded-md bg-white px-2 py-1 text-xs font-bold text-slate-700 ring-1 ring-slate-200">
              <BadgeCheck aria-hidden="true" size={14} className="text-[#10b981]" />
              {product.storeRating.toFixed(1)}
            </span>
          </div>
          <div className="mt-3 grid gap-2 text-xs font-semibold text-slate-600">
            <span className="flex items-center gap-2">
              <Users aria-hidden="true" size={15} className="text-[#07515b]" />
              تقييم العملاء للتاجر {product.merchantCustomerRating.toFixed(1)} من 5
            </span>
            <span className="flex items-center gap-2">
              <MessageCircle aria-hidden="true" size={15} className="text-[#07515b]" />
              {product.merchantReviewCount.toLocaleString("ar")} مراجعة · {product.merchantReliabilityLabel}
            </span>
            <span className="flex items-center gap-2">
              <Truck aria-hidden="true" size={15} className="text-[#07515b]" />
              {product.shippingInfo}
            </span>
            <span className="flex items-center gap-2">
              <ShieldCheck aria-hidden="true" size={15} className="text-[#07515b]" />
              {product.returnPolicy}
            </span>
          </div>
        </div>

        <div className="rounded-md border border-[#ff5a5f]/25 bg-[#ff5a5f]/10 p-3">
          <div className="flex gap-2">
            <Sparkles aria-hidden="true" size={16} className="mt-1 shrink-0 text-[#a8322d]" />
            <p className="line-clamp-3 text-sm font-semibold leading-6 text-slate-800">
              {"insight" in product ? product.insight.whyThisOption : product.comparisonReason}
            </p>
          </div>
          {"insight" in product ? (
            <div className="mt-3 grid grid-cols-3 gap-2 text-center">
              <ScorePill label="يناسبك" value={`${product.insight.matchScore}%`} />
              <ScorePill label="قوة العرض" value={`${product.insight.valueScore}%`} />
              <ScorePill label="السعر" value={`${product.insight.priceScore}%`} />
            </div>
          ) : null}
        </div>

        <div className="mt-auto flex items-end justify-between gap-3">
          <div>
            <p className="text-xs font-semibold text-slate-500">أفضل سعر متاح</p>
            <div className="mt-1 flex flex-wrap items-baseline gap-2">
              <p className="text-2xl font-black text-slate-950">{formatter.format(product.price)}</p>
              {product.originalPrice ? (
                <p className="text-sm font-bold text-slate-400 line-through">{formatter.format(product.originalPrice)}</p>
              ) : null}
            </div>
          </div>
          <p className="trust-chip rounded-md px-3 py-2 text-xs font-bold">
            {product.soldLastHour} مهتم الآن
          </p>
        </div>

        <div className="grid grid-cols-[1fr_auto] gap-2">
          <button
            type="button"
            onClick={() => onBuy(product)}
            className="primary-action focus-ring flex items-center justify-center gap-2 rounded-md px-4 py-3 text-sm font-black text-white transition"
          >
            متابعة الشراء
            <ChevronLeft aria-hidden="true" size={17} />
          </button>
          <Link
            href={`/product/${product.id}`}
            className="focus-ring rounded-md border border-slate-300 px-4 py-3 text-center text-sm font-bold text-slate-800 transition hover:border-slate-950 hover:bg-slate-50"
          >
            التفاصيل
          </Link>
        </div>
      </div>
    </article>
  );
}

function ScorePill({ label, value }: { label: string; value: string }) {
  return (
    <div className="rounded-md bg-white px-2 py-1 ring-1 ring-amber-200">
      <p className="text-[10px] font-bold text-slate-500">{label}</p>
      <p className="mt-0.5 text-xs font-black text-slate-950">{value}</p>
    </div>
  );
}
