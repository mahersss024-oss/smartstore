"use client";

import { ExternalLink, LockKeyhole, ShieldCheck, Store, X } from "lucide-react";
import { useEffect, useState } from "react";
import type { Product } from "@/lib/types";

type Props = {
  product: Product | null;
  onClose: () => void;
  checkoutUrl?: string;
};

export function CheckoutModal({ product, onClose, checkoutUrl }: Props) {
  const [showFallback, setShowFallback] = useState(false);

  useEffect(() => {
    if (!product) return;
    setShowFallback(false);
    const timer = window.setTimeout(() => setShowFallback(true), 4500);
    return () => window.clearTimeout(timer);
  }, [product]);

  if (!product) return null;

  const formatter = new Intl.NumberFormat("ar", {
    style: "currency",
    currency: product.currency || "USD",
  });
  const destinationUrl = checkoutUrl || product.affiliateUrl;

  return (
    <div className="fixed inset-0 z-50 bg-slate-950/75 p-3 backdrop-blur-sm sm:p-6" role="dialog" aria-modal="true">
      <div className="mx-auto flex h-full max-w-6xl flex-col overflow-hidden rounded-lg bg-white shadow-soft">
        <div className="border-b border-slate-200 bg-white">
          <div className="flex flex-col gap-4 px-4 py-4 lg:flex-row lg:items-center lg:justify-between">
            <div className="flex min-w-0 gap-3">
              <div className="brand-mark flex h-12 w-12 shrink-0 items-center justify-center rounded-lg text-white">
                <LockKeyhole aria-hidden="true" size={21} />
              </div>
              <div className="min-w-0">
                <p className="text-xs font-black uppercase tracking-wide text-[#07515b]">إتمام الشراء الآمن</p>
                <h2 className="mt-1 line-clamp-1 text-base font-black text-slate-950 sm:text-lg">{product.title}</h2>
                <p className="mt-1 text-xs font-semibold text-slate-500">
                  سيتم إتمام الطلب عبر المتجر الشريك المسؤول عن الدفع والشحن وخدمة ما بعد البيع.
                </p>
              </div>
            </div>

            <div className="flex flex-wrap items-center gap-2 text-xs font-semibold text-slate-700">
              <span className="flex items-center gap-1 rounded-md bg-[#10b981]/10 px-3 py-2 text-[#066348]">
                <ShieldCheck aria-hidden="true" size={15} />
                اتصال آمن
              </span>
              <span className="flex items-center gap-1 rounded-md bg-slate-100 px-3 py-2 text-slate-700">
                <Store aria-hidden="true" size={15} />
                {product.storeName}
              </span>
              <button
                className="primary-action focus-ring flex items-center gap-2 rounded-md px-4 py-2 text-sm font-bold text-white transition"
                onClick={onClose}
                type="button"
              >
                <X aria-hidden="true" size={16} />
                إغلاق
              </button>
            </div>
          </div>

          <div className="grid gap-3 border-t border-slate-100 bg-slate-50 px-4 py-3 text-sm sm:grid-cols-4">
            <CheckoutFact label="السعر" value={formatter.format(product.price)} />
            <CheckoutFact label="موثوقية التاجر" value={`${product.merchantReliabilityScore}%`} />
            <CheckoutFact label="الشحن" value={product.shippingInfo} />
            <CheckoutFact label="تقييم العملاء" value={`${product.merchantCustomerRating.toFixed(1)} / 5`} />
          </div>
        </div>

        <div className="grid min-h-0 flex-1 lg:grid-cols-[1fr_280px]">
          <div className="relative min-h-[520px] bg-white lg:min-h-0">
            <iframe
              title={`Checkout for ${product.title}`}
              src={destinationUrl}
              onLoad={() => setShowFallback(false)}
              className="h-full min-h-[520px] w-full border-0 bg-white lg:min-h-0"
              sandbox="allow-forms allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"
            />
            {showFallback ? (
              <div className="absolute inset-x-4 bottom-4 rounded-lg border border-[#ff5a5f]/25 bg-[#ff5a5f]/10 p-4 shadow-soft">
                <p className="text-sm font-black text-slate-950">إذا لم تظهر صفحة الشراء هنا</p>
                <p className="mt-1 text-sm font-semibold leading-6 text-slate-700">
                  بعض المتاجر تعرض صفحة الشراء في نافذة المتجر فقط. يمكنك المتابعة بأمان من الرابط التالي.
                </p>
                <a
                  href={destinationUrl}
                  className="primary-action focus-ring mt-3 inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-black text-white"
                >
                  متابعة الشراء من المتجر
                  <ExternalLink aria-hidden="true" size={16} />
                </a>
              </div>
            ) : null}
          </div>

          <aside className="border-t border-slate-200 bg-white p-4 lg:border-r lg:border-t-0">
            <p className="text-sm font-black text-slate-950">قبل المتابعة</p>
            <div className="mt-4 space-y-3 text-sm font-semibold leading-6 text-slate-600">
              <p>نساعدك في اختيار العرض الأنسب، بينما يتم تنفيذ الطلب والدفع عبر المتجر الشريك.</p>
              <p>
                التاجر: {product.merchantReliabilityLabel} · {product.merchantReviewCount.toLocaleString("ar")} مراجعة · سرعة رد {product.merchantResponseRate}%.
              </p>
              <p>قد تحتوي بعض العروض على روابط شراكة، ولن يضيف ذلك أي تكلفة عليك.</p>
              <a
                href={destinationUrl}
                className="focus-ring mt-2 flex items-center justify-center gap-2 rounded-md border border-slate-300 px-4 py-3 text-sm font-black text-slate-800 transition hover:border-slate-950 hover:bg-slate-50"
              >
                متابعة الشراء من المتجر
                <ExternalLink aria-hidden="true" size={16} />
              </a>
            </div>
          </aside>
        </div>
      </div>
    </div>
  );
}

function CheckoutFact({ label, value }: { label: string; value: string }) {
  return (
    <div className="min-w-0 rounded-md bg-white px-3 py-2 ring-1 ring-slate-200">
      <p className="text-xs font-semibold text-slate-500">{label}</p>
      <p className="mt-1 truncate text-sm font-black text-slate-950">{value}</p>
    </div>
  );
}
