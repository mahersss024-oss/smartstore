"use client";

import { BadgeCheck, ChevronLeft, MessageCircle, ShieldCheck, Sparkles, Star, Store, Truck, Users } from "lucide-react";
import Link from "next/link";
import { useState } from "react";
import type { ReactNode } from "react";
import { CheckoutModal } from "@/components/CheckoutModal";
import { buildGoUrl } from "@/lib/go-url";
import type { Product } from "@/lib/types";

type Props = {
  product: Product;
};

export function CheckoutProductDetail({ product }: Props) {
  const [checkoutProduct, setCheckoutProduct] = useState<Product | null>(null);
  const checkoutUrl = buildGoUrl(product.id, { source: "product-page", campaign: "organic" });
  const formatter = new Intl.NumberFormat("ar", {
    style: "currency",
    currency: product.currency || "USD",
  });

  return (
    <>
      <main className="min-h-screen bg-[var(--canvas)]">
        <header className="border-b border-slate-200 bg-white">
          <div className="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <Link href="/" className="text-sm font-black text-slate-950">
              SmartStore AI
            </Link>
            <span className="trust-chip rounded-md px-3 py-2 text-xs font-bold">
              صفحة منتج مهيأة لمحركات البحث
            </span>
          </div>
        </header>

        <section className="mx-auto grid max-w-7xl gap-8 px-4 py-8 sm:px-6 lg:grid-cols-[520px_1fr] lg:px-8">
          <div className="space-y-4">
            <div className="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
              <img src={product.image} alt={product.title} className="aspect-[4/3] h-full w-full object-cover" />
            </div>

            <div className="rounded-lg border border-slate-200 bg-white p-4">
              <p className="text-sm font-black text-slate-950">المتجر والتاجر</p>
              <div className="mt-4 grid gap-3 text-sm font-semibold text-slate-600">
                <InfoRow icon={<Store size={17} />} label="المتجر" value={product.storeName} />
                <InfoRow icon={<BadgeCheck size={17} />} label="التاجر" value={product.merchantName} />
                <InfoRow icon={<Users size={17} />} label="تقييم العملاء للتاجر" value={`${product.merchantCustomerRating.toFixed(1)} من 5`} />
                <InfoRow icon={<MessageCircle size={17} />} label="مراجعات التاجر" value={`${product.merchantReviewCount.toLocaleString("ar")} مراجعة`} />
                <InfoRow icon={<Truck size={17} />} label="الشحن" value={product.shippingInfo} />
                <InfoRow icon={<ShieldCheck size={17} />} label="الإرجاع" value={product.returnPolicy} />
              </div>
            </div>
          </div>

          <div className="space-y-6">
            <div>
              <p className="text-sm font-black uppercase tracking-wide text-[#a8322d]">{product.category}</p>
              <h1 className="mt-2 text-4xl font-black leading-tight text-slate-950">{product.title}</h1>
              <p className="mt-4 max-w-2xl text-lg font-medium leading-8 text-slate-600">{product.description}</p>
            </div>

            <div className="grid gap-3 sm:grid-cols-4">
              <Metric label="السعر" value={formatter.format(product.price)} />
              <Metric label="التقييم" value={product.rating.toFixed(1)} />
              <Metric label="الخصم" value={`${product.discountPercent}%`} />
              <Metric label="موثوقية التاجر" value={`${product.merchantReliabilityScore}%`} />
            </div>

            <div className="rounded-lg border border-emerald-200 bg-emerald-50 p-5">
              <p className="text-sm font-black text-emerald-800">موثوقية التاجر</p>
              <div className="mt-4 grid gap-3 sm:grid-cols-3">
                <Metric label="مستوى الثقة" value={product.merchantReliabilityLabel} />
                <Metric label="تقييم العملاء" value={`${product.merchantCustomerRating.toFixed(1)} / 5`} />
                <Metric label="سرعة الرد" value={`${product.merchantResponseRate}%`} />
              </div>
              <p className="mt-3 text-sm font-semibold leading-6 text-emerald-900">
                هذا التاجر موثق لدينا منذ {product.merchantVerifiedSince}، وتم تقييمه بناءً على آراء العملاء، مستوى الخدمة، ووضوح سياسات الشحن والإرجاع.
              </p>
            </div>

            <div className="rounded-lg border border-amber-200 bg-amber-50 p-5">
              <div className="flex gap-3">
                <Sparkles aria-hidden="true" size={22} className="mt-1 shrink-0 text-[#07515b]" />
                <div>
                  <p className="text-sm font-black text-[#07515b]">تحليل الذكاء الاصطناعي</p>
                  <p className="mt-2 text-lg font-black leading-8 text-slate-950">{product.aiExplanation}</p>
                </div>
              </div>
            </div>

            <div className="grid gap-4 md:grid-cols-2">
              <ListBox title="نقاط القوة" items={product.pros} tone="green" />
              <ListBox title="ملاحظات قبل الشراء" items={product.cons} tone="slate" />
            </div>

            <div className="rounded-lg border border-slate-200 bg-white p-5">
              <p className="text-sm font-black text-slate-950">سبب اختيار هذا العرض</p>
              <p className="mt-2 text-base font-semibold leading-7 text-slate-600">{product.comparisonReason}</p>
              <div className="mt-4 flex items-center gap-2 text-sm font-bold text-slate-700">
                <Star aria-hidden="true" size={17} className="fill-amber-400 text-amber-400" />
                تقييم المتجر {product.storeRating.toFixed(1)} من 5
              </div>
            </div>

            <button
              type="button"
              onClick={() => setCheckoutProduct(product)}
              className="primary-action focus-ring flex w-full items-center justify-center gap-2 rounded-md px-6 py-4 text-lg font-black text-white transition sm:w-auto"
            >
              متابعة الشراء بأفضل سعر
              <ChevronLeft aria-hidden="true" size={20} />
            </button>
          </div>
        </section>
      </main>

      <CheckoutModal product={checkoutProduct} checkoutUrl={checkoutUrl} onClose={() => setCheckoutProduct(null)} />
    </>
  );
}

function Metric({ label, value }: { label: string; value: string }) {
  return (
    <div className="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
      <p className="text-xs font-semibold text-slate-500">{label}</p>
      <p className="mt-1 text-xl font-black text-slate-950">{value}</p>
    </div>
  );
}

function InfoRow({ icon, label, value }: { icon: ReactNode; label: string; value: string }) {
  return (
    <div className="flex items-start gap-3 rounded-md bg-slate-50 p-3">
      <span className="mt-0.5 text-[#07515b]">{icon}</span>
      <div className="min-w-0">
        <p className="text-xs font-bold text-slate-500">{label}</p>
        <p className="mt-1 break-words text-sm font-black text-slate-950">{value}</p>
      </div>
    </div>
  );
}

function ListBox({ title, items, tone }: { title: string; items: string[]; tone: "green" | "slate" }) {
  const marker = tone === "green" ? "bg-emerald-500" : "bg-slate-500";

  return (
    <div className="rounded-lg border border-slate-200 bg-white p-5">
      <p className="text-sm font-black text-slate-950">{title}</p>
      <div className="mt-3 space-y-2">
        {items.map((item) => (
          <div key={item} className="flex gap-2 text-sm font-semibold leading-6 text-slate-600">
            <span className={`mt-2 h-2 w-2 shrink-0 rounded-full ${marker}`} />
            <span>{item}</span>
          </div>
        ))}
      </div>
    </div>
  );
}
