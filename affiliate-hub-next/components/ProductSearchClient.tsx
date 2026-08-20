"use client";

import {
  BarChart3,
  ChevronLeft,
  CheckCircle2,
  Clock3,
  Flame,
  Gauge,
  Search,
  ShieldCheck,
  SlidersHorizontal,
  Sparkles,
  ScanSearch,
  Star,
  Store,
  TrendingUp,
  Truck,
  Users,
  Zap,
} from "lucide-react";
import { FormEvent, useMemo, useState } from "react";
import type { ReactNode } from "react";
import { CheckoutModal } from "@/components/CheckoutModal";
import { MarketingBanner } from "@/components/MarketingBanner";
import { ProductCard } from "@/components/ProductCard";
import { buildGoUrl } from "@/lib/go-url";
import type { MarketingResponse, Product, ProductRecognition, ProductsApiResponse, RankedProduct } from "@/lib/types";

type Props = {
  initialProducts: RankedProduct[];
  initialRecognition: ProductRecognition;
  initialQuery?: string;
  initialMarketingCopy?: string;
  initialPage?: number;
  initialPageSize?: number;
  initialTotal?: number;
  initialHasMore?: boolean;
};

type SortMode = "recommended" | "lowest-price" | "highest-trust";

export function ProductSearchClient({
  initialProducts,
  initialRecognition,
  initialQuery = "",
  initialMarketingCopy,
  initialPage = 1,
  initialPageSize = 24,
  initialTotal = initialProducts.length,
  initialHasMore = false,
}: Props) {
  const [query, setQuery] = useState(initialQuery);
  const [products, setProducts] = useState<RankedProduct[]>(initialProducts);
  const [recognition, setRecognition] = useState(initialRecognition);
  const [page, setPage] = useState(initialPage);
  const [pageSize, setPageSize] = useState(initialPageSize);
  const [totalProducts, setTotalProducts] = useState(initialTotal);
  const [hasMore, setHasMore] = useState(initialHasMore);
  const [sortMode, setSortMode] = useState<SortMode>("recommended");
  const [marketingCopy, setMarketingCopy] = useState(
    initialMarketingCopy ?? "نقارن لك العروض المتاحة ونرشح الخيار الأنسب حسب السعر، جودة العرض، وثقة المتجر."
  );
  const [isLoading, setIsLoading] = useState(false);
  const [isLoadingMore, setIsLoadingMore] = useState(false);
  const [checkoutProduct, setCheckoutProduct] = useState<Product | null>(null);
  const [checkoutUrl, setCheckoutUrl] = useState("");

  const formatter = new Intl.NumberFormat("ar", {
    style: "currency",
    currency: products[0]?.currency || "USD",
  });

  const sortedProducts = useMemo(() => {
    const copy = [...products];

    if (sortMode === "lowest-price") return copy.sort((a, b) => a.price - b.price);
    if (sortMode === "highest-trust") return copy.sort((a, b) => b.merchantReliabilityScore - a.merchantReliabilityScore);

    return copy.sort((a, b) => {
      const first = a.insight.valueScore + a.insight.matchScore;
      const second = b.insight.valueScore + b.insight.matchScore;
      return second - first;
    });
  }, [products, sortMode]);

  const bestProduct = useMemo(() => sortedProducts[0], [sortedProducts]);

  const topOptions = useMemo(() => sortedProducts.slice(0, 3), [sortedProducts]);

  const cheapestProduct = useMemo(() => {
    return [...products].sort((a, b) => a.price - b.price)[0];
  }, [products]);

  const mostTrustedProduct = useMemo(() => {
    return [...products].sort((a, b) => b.merchantReliabilityScore - a.merchantReliabilityScore)[0];
  }, [products]);

  const customerFavoriteProduct = useMemo(() => {
    return [...products].sort((a, b) => {
      const first = a.merchantCustomerRating * 20 + Math.min(20, a.merchantReviewCount / 100);
      const second = b.merchantCustomerRating * 20 + Math.min(20, b.merchantReviewCount / 100);
      return second - first;
    })[0];
  }, [products]);

  const compassScore = bestProduct
    ? Math.round((bestProduct.insight.valueScore + bestProduct.insight.priceScore + bestProduct.merchantReliabilityScore) / 3)
    : 0;

  const bestSavings = bestProduct?.originalPrice
    ? Math.max(0, bestProduct.originalPrice - bestProduct.price)
    : 0;

  const priceSpread = useMemo(() => {
    if (!products.length) return 0;
    const prices = products.map((product) => product.price).filter((price) => price > 0);
    if (!prices.length) return 0;
    return Math.max(...prices) - Math.min(...prices);
  }, [products]);

  const averageTrust = useMemo(() => {
    if (!products.length) return 0;
    return Math.round(products.reduce((sum, product) => sum + product.merchantReliabilityScore, 0) / products.length);
  }, [products]);

  async function searchProducts(searchTerm: string) {
    setIsLoading(true);

    try {
      const productsResponse = await fetch(`/api/products?q=${encodeURIComponent(searchTerm)}&page=1&pageSize=${pageSize}`, { cache: "no-store" });
      const productsPayload = (await productsResponse.json()) as ProductsApiResponse;
      const marketingResponse = await fetch("/api/marketing", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          query: searchTerm,
          products: productsPayload.products.map((product) => ({
            title: product.title,
            price: product.price,
            currency: product.currency,
            discountPercent: product.discountPercent,
            storeName: product.storeName,
            merchantReliabilityScore: product.merchantReliabilityScore,
            merchantCustomerRating: product.merchantCustomerRating,
            comparisonReason: product.insight.whyThisOption,
          })),
        }),
      });
      const marketingPayload = (await marketingResponse.json()) as MarketingResponse;

      setProducts(Array.isArray(productsPayload.products) ? productsPayload.products : []);
      if (productsPayload.recognition) setRecognition(productsPayload.recognition);
      setPage(productsPayload.page ?? 1);
      setPageSize(productsPayload.pageSize ?? pageSize);
      setTotalProducts(productsPayload.total ?? productsPayload.products.length);
      setHasMore(Boolean(productsPayload.hasMore));
      setMarketingCopy(marketingPayload.copy);
    } finally {
      setIsLoading(false);
    }
  }

  async function loadMoreProducts() {
    if (!hasMore || isLoadingMore) return;

    setIsLoadingMore(true);

    try {
      const nextPage = page + 1;
      const productsResponse = await fetch(
        `/api/products?q=${encodeURIComponent(query.trim())}&page=${nextPage}&pageSize=${pageSize}`,
        { cache: "no-store" }
      );
      const productsPayload = (await productsResponse.json()) as ProductsApiResponse;
      const nextProducts = Array.isArray(productsPayload.products) ? productsPayload.products : [];

      setProducts((currentProducts) => {
        const existingIds = new Set(currentProducts.map((product) => product.id));
        return [...currentProducts, ...nextProducts.filter((product) => !existingIds.has(product.id))];
      });
      setPage(productsPayload.page ?? nextPage);
      setPageSize(productsPayload.pageSize ?? pageSize);
      setTotalProducts(productsPayload.total ?? totalProducts);
      setHasMore(Boolean(productsPayload.hasMore));
      if (productsPayload.recognition) setRecognition(productsPayload.recognition);
    } finally {
      setIsLoadingMore(false);
    }
  }

  async function handleSearch(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();
    await searchProducts(query.trim());
  }

  function openCheckout(product: Product, source = "search-results") {
    setCheckoutProduct(product);
    setCheckoutUrl(buildGoUrl(product.id, {
      source,
      campaign: "onsite",
      q: query.trim(),
    }));
  }

  return (
    <>
      <header className="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div className="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
          <div className="flex items-center gap-3">
            <div className="brand-mark flex h-10 w-10 items-center justify-center rounded-lg text-white shadow-sm">
              <Sparkles aria-hidden="true" size={20} />
            </div>
            <div>
              <p className="text-sm font-black text-slate-950">SmartStore AI</p>
              <p className="hidden text-xs font-semibold text-slate-500 sm:block">اختيار أوضح قبل الشراء</p>
            </div>
          </div>

          <nav className="hidden items-center gap-6 text-sm font-bold text-slate-600 md:flex">
            <a href="#deals" className="transition hover:text-slate-950">الخيار الأنسب</a>
            <a href="#decision" className="transition hover:text-slate-950">المقارنة</a>
            <a href="#selection" className="transition hover:text-slate-950">التفاصيل</a>
          </nav>

          <div className="trust-chip hidden items-center gap-2 rounded-md px-3 py-2 text-xs font-black sm:flex">
            <ShieldCheck aria-hidden="true" size={15} />
            عروض من متاجر موثوقة
          </div>
        </div>
      </header>

      <main className="bg-[var(--canvas)]">
        <section className="hero-stage relative overflow-hidden border-b border-slate-900">
          <div className="relative z-10 mx-auto grid max-w-[1680px] gap-8 px-4 py-8 sm:px-6 lg:grid-cols-[minmax(0,1fr)_420px] lg:px-8 lg:py-10">
            <div className="flex min-h-[620px] flex-col justify-between gap-8">
              <div className="space-y-5">
                <div className="glass-chip inline-flex items-center gap-2 rounded-md px-3 py-2 text-xs font-black data-pulse">
                  <TrendingUp aria-hidden="true" size={15} />
                  كل نتيجة يجب أن تساعدك على قرار شراء أوضح
                </div>

                <div className="space-y-4">
                  <h1 className="max-w-5xl text-4xl font-black leading-tight text-white sm:text-5xl lg:text-6xl">
                    اعرف أين تشتري، ولماذا هذا هو الخيار الأنسب.
                  </h1>
                  <p className="max-w-3xl text-base font-semibold leading-8 text-slate-200">
                    نعرض لك أفضل الخيارات مع التفاصيل التي تغيّر القرار: السعر، ثقة التاجر، تقييم العملاء، الشحن، الإرجاع، وسبب الترشيح.
                  </p>
                </div>

                <form onSubmit={handleSearch} className="command-bar max-w-5xl rounded-lg p-3 shadow-soft">
                  <div className="grid gap-3 sm:grid-cols-[1fr_auto]">
                    <label className="relative block">
                      <span className="sr-only">البحث عن منتج</span>
                      <Search
                        aria-hidden="true"
                        size={21}
                        className="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"
                      />
                      <input
                        className="focus-ring min-h-16 w-full rounded-md border border-slate-200 bg-white px-12 text-base font-semibold text-slate-950 placeholder:text-slate-400"
                        value={query}
                        onChange={(event) => setQuery(event.target.value)}
                        placeholder="اكتب اسم المنتج أو الفئة..."
                        type="search"
                      />
                    </label>
                    <button
                      className="primary-action focus-ring flex min-h-16 items-center justify-center gap-2 rounded-md px-8 text-base font-black text-white transition disabled:cursor-wait disabled:bg-slate-500"
                      disabled={isLoading}
                      type="submit"
                    >
                      {isLoading ? "نبحث عن أفضل عرض" : "اعرض النتائج"}
                      <ChevronLeft aria-hidden="true" size={18} />
                    </button>
                  </div>

                </form>

                <div className="intelligence-strip glass-panel grid gap-3 rounded-lg p-3 sm:grid-cols-2 xl:grid-cols-4">
                  <InsightSignal icon={<ScanSearch size={18} />} title="مسح السوق" value={`${totalProducts} عرض`} text={`${products.length} معروض الآن`} />
                  <InsightSignal icon={<Gauge size={18} />} title="جاهزية القرار" value={`${compassScore}%`} text="توازن السعر والثقة والقيمة" />
                  <InsightSignal icon={<Zap size={18} />} title="فرق السعر" value={formatter.format(priceSpread)} text="نقارن الفروقات قبل الاختيار" />
                  <InsightSignal icon={<CheckCircle2 size={18} />} title="ثقة المتاجر" value={`${averageTrust}%`} text="متوسط موثوقية البائعين" />
                </div>

              </div>
            </div>

            <aside className="recommendation-orbit surface-grid overflow-hidden rounded-lg text-white shadow-soft">
              <div className="relative aspect-[4/3] bg-slate-900 lg:aspect-[4/4]">
                {bestProduct ? (
                  <img src={bestProduct.image} alt={bestProduct.title} className="h-full w-full object-cover opacity-90" />
                ) : null}
                <div className="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/35 to-transparent" />
                <div className="data-scan absolute inset-x-0 top-0 h-20" />
                <div className="absolute inset-x-4 bottom-4">
                  <p className="text-xs font-black text-[#8beeff]">أفضل ترشيح الآن</p>
                  <h2 className="mt-2 line-clamp-2 text-2xl font-black leading-8">
                    {bestProduct?.title ?? "ابدأ البحث لعرض أفضل الخيارات"}
                  </h2>
                </div>
              </div>

              <div className="space-y-4 p-5">
                {bestProduct ? (
                  <div className="grid grid-cols-2 gap-2">
                    <HeroBadge label="التوفير المحتمل" value={bestSavings ? formatter.format(bestSavings) : "أفضل قيمة"} />
                    <HeroBadge label="سبب الترشيح" value={bestProduct.insight.bestFor} />
                  </div>
                ) : null}

                <div className="grid grid-cols-3 gap-2 text-center">
                  <DarkMetric label="العروض" value={`${products.length}/${totalProducts}`} />
                  <DarkMetric label="الثقة" value={bestProduct ? `${bestProduct.trustScore}%` : "--"} />
                  <DarkMetric label="التقييم" value={bestProduct ? bestProduct.storeRating.toFixed(1) : "--"} />
                </div>

                {bestProduct ? (
                  <>
                    <div className="rounded-lg border border-white/10 bg-white/5 p-4">
                      <p className="text-xs font-bold text-slate-300">السعر الحالي</p>
                      <p className="mt-1 text-3xl font-black">{formatter.format(bestProduct.price)}</p>
                      <p className="mt-2 line-clamp-3 text-sm font-semibold leading-6 text-slate-300">
                        {bestProduct.insight.whyThisOption}
                      </p>
                      <div className="mt-4 space-y-3">
                        <SignalBar label="قوة العرض" value={bestProduct.insight.valueScore} />
                        <SignalBar label="موثوقية التاجر" value={bestProduct.merchantReliabilityScore} />
                        <SignalBar label="مطابقة البحث" value={bestProduct.insight.matchScore} />
                      </div>
                    </div>

                    <button
                      type="button"
                      onClick={() => openCheckout(bestProduct, "hero-best-offer")}
                      className="focus-ring flex w-full items-center justify-center gap-2 rounded-md bg-white px-4 py-3 text-sm font-black text-slate-950 transition hover:bg-slate-100"
                    >
                      متابعة العرض الأفضل
                      <ChevronLeft aria-hidden="true" size={17} />
                    </button>
                  </>
                ) : null}
              </div>
            </aside>
          </div>
        </section>

        <section id="deals" className="mx-auto max-w-[1480px] space-y-6 px-4 py-8 sm:px-6 lg:px-8">
          <MarketingBanner copy={marketingCopy} isLoading={isLoading} />

          {bestProduct ? (
            <section className="spotlight-deal overflow-hidden rounded-lg bg-white shadow-sm">
              <div className="grid lg:grid-cols-[420px_minmax(0,1fr)]">
                <div className="relative min-h-[320px] bg-slate-950">
                  <img src={bestProduct.image} alt={bestProduct.title} className="h-full min-h-[320px] w-full object-cover opacity-90" />
                  <div className="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/35 to-transparent" />
                  <div className="absolute bottom-4 right-4 left-4">
                    <p className="text-xs font-black text-[#8beeff]">عرض يستحق الانتباه</p>
                    <h2 className="mt-2 line-clamp-2 text-2xl font-black leading-8 text-white">{bestProduct.title}</h2>
                  </div>
                </div>

                <div className="p-5 lg:p-6">
                  <div className="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                      <p className="text-xs font-black text-[#07515b]">اختيار الذكاء لهذا البحث</p>
                      <h2 className="mt-2 max-w-2xl text-3xl font-black leading-tight text-slate-950">
                        أفضل توازن بين السعر والثقة وجودة العرض.
                      </h2>
                    </div>
                    <div className="rounded-lg bg-slate-950 px-4 py-3 text-white">
                      <p className="text-xs font-bold text-slate-300">السعر الآن</p>
                      <p className="mt-1 text-2xl font-black">{formatter.format(bestProduct.price)}</p>
                    </div>
                  </div>

                  <p className="mt-4 max-w-3xl text-sm font-semibold leading-7 text-slate-600">{bestProduct.insight.whyThisOption}</p>

                  <div className="mt-5 grid gap-3 sm:grid-cols-3">
                    <SpotlightMetric label="يناسبك" value={`${bestProduct.insight.matchScore}%`} />
                    <SpotlightMetric label="قوة العرض" value={`${bestProduct.insight.valueScore}%`} />
                    <SpotlightMetric label="موثوقية التاجر" value={`${bestProduct.merchantReliabilityScore}%`} />
                  </div>

                  <div className="mt-5 flex flex-col gap-3 sm:flex-row">
                    <button
                      type="button"
                      onClick={() => openCheckout(bestProduct, "spotlight")}
                      className="primary-action focus-ring flex items-center justify-center gap-2 rounded-md px-5 py-3 text-sm font-black text-white"
                    >
                      متابعة العرض الموصى به
                      <ChevronLeft aria-hidden="true" size={17} />
                    </button>
                    <button
                      type="button"
                      onClick={() => setSortMode("lowest-price")}
                      className="focus-ring rounded-md border border-slate-300 bg-white px-5 py-3 text-sm font-black text-slate-800 transition hover:border-slate-950"
                    >
                      مشاهدة الأرخص
                    </button>
                  </div>
                </div>
              </div>
            </section>
          ) : null}

          {bestProduct ? (
            <section id="decision" className="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <div className="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                  <div>
                    <p className="text-xs font-black text-[#a8322d]">اختيار حسب الأولوية</p>
                    <h2 className="mt-1 text-xl font-black text-slate-950">اختر بالطريقة التي تناسبك</h2>
                  </div>
                  <span className="ai-chip rounded-md border px-3 py-2 text-xs font-black">كل بطاقة تخدم قرارا مختلفا</span>
                </div>

                <div className="mt-4 grid gap-3 md:grid-cols-2 xl:grid-cols-4">
                  <DecisionTile
                    icon={<Flame size={18} />}
                    title="الخيار الأنسب"
                    product={bestProduct}
                    value={formatter.format(bestProduct.price)}
                  />
                  <DecisionTile
                    icon={<BarChart3 size={18} />}
                    title="الأقل سعراً"
                    product={cheapestProduct}
                    value={cheapestProduct ? formatter.format(cheapestProduct.price) : "--"}
                  />
                  <DecisionTile
                    icon={<ShieldCheck size={18} />}
                    title="الأعلى ثقة"
                    product={mostTrustedProduct}
                    value={mostTrustedProduct ? `${mostTrustedProduct.merchantReliabilityScore}%` : "--"}
                  />
                  <DecisionTile
                    icon={<Users size={18} />}
                    title="الأفضل بتقييم العملاء"
                    product={customerFavoriteProduct}
                    value={customerFavoriteProduct ? `${customerFavoriteProduct.merchantCustomerRating.toFixed(1)} / 5` : "--"}
                  />
                </div>
            </section>
          ) : null}

          {topOptions.length ? (
            <section className="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
              <div className="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                  <p className="text-xs font-black text-[#07515b]">مصفوفة العرض الذكية</p>
                  <h2 className="mt-1 text-xl font-black text-slate-950">قرار الشراء في لقطة واحدة</h2>
                </div>
                <div className="ai-chip flex w-fit items-center gap-2 rounded-md border px-3 py-2 text-xs font-black">
                  <Sparkles aria-hidden="true" size={15} />
                  مقارنة حسب السعر والثقة والقيمة
                </div>
              </div>

              <div className="divide-y divide-slate-100">
                {topOptions.map((product) => (
                  <MatrixRow
                    key={product.id}
                    product={product}
                    price={formatter.format(product.price)}
                    onBuy={() => openCheckout(product, "smart-matrix")}
                  />
                ))}
              </div>
            </section>
          ) : null}

          <div id="selection" className="grid gap-4 lg:grid-cols-[340px_minmax(0,1fr)]">
            <section className="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
              <div className="flex items-center justify-between gap-3">
                <div>
                  <p className="text-xs font-black uppercase text-[#07515b]">نتيجة البحث</p>
                  <h2 className="mt-1 text-xl font-black text-slate-950">{recognition.detectedCategory}</h2>
                </div>
                <div className="trust-chip rounded-md px-3 py-2 text-center">
                  <p className="text-xs font-bold">مطابقة</p>
                  <p className="text-lg font-black">{recognition.confidence}%</p>
                </div>
              </div>

              <p className="mt-4 text-sm font-semibold leading-7 text-slate-600">{recognition.summary}</p>

              <div className="mt-4 flex flex-wrap gap-2">
                {recognition.comparedSignals.map((signal) => (
                  <span key={signal} className="rounded-md border border-slate-200 bg-slate-50 px-2.5 py-1.5 text-xs font-bold text-slate-700">
                    {signal}
                  </span>
                ))}
              </div>
            </section>

            <section className="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
              <div className="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                  <p className="text-xs font-black uppercase text-[#a8322d]">تفاصيل القرار</p>
                  <h2 className="mt-1 text-xl font-black text-slate-950">ما الذي يهم قبل اختيار العرض؟</h2>
                </div>
                <div className="flex items-center gap-2 rounded-md bg-slate-50 px-3 py-2 text-xs font-bold text-slate-600">
                  <Clock3 aria-hidden="true" size={15} />
                  الأسعار والتوفر قد تتغير
                </div>
              </div>

              <div className="mt-4 grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                <DecisionFactor icon={<Zap size={17} />} title="السعر الحقيقي" text="نقارن السعر الحالي والخصم وفارق السعر بين البدائل." />
                <DecisionFactor icon={<ShieldCheck size={17} />} title="ثقة التاجر" text="نراجع موثوقية التاجر وتقييم العملاء وعدد المراجعات." />
                <DecisionFactor icon={<Truck size={17} />} title="الشحن والإرجاع" text="نوضح الشحن وسياسة الإرجاع عندما تكون متاحة من مصدر العرض." />
                <DecisionFactor icon={<Star size={17} />} title="جودة الاختيار" text="نوازن بين تقييم المنتج وقوة العرض وليس السعر وحده." />
                <DecisionFactor icon={<Store size={17} />} title="المتجر المسؤول" text="نعرض اسم المتجر والتاجر حتى تعرف من ينفذ الطلب." />
                <DecisionFactor icon={<Sparkles size={17} />} title="سبب الترشيح" text="كل عرض يظهر معه سبب واضح يشرح لماذا يستحق النظر." />
              </div>
            </section>
          </div>

          <div className="flex flex-col gap-3 border-b border-slate-200 pb-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
              <p className="text-sm font-black text-slate-950">كل العروض المناسبة</p>
              <p className="mt-1 text-sm font-semibold text-slate-500">
                يعرض {products.length.toLocaleString("ar")} من {totalProducts.toLocaleString("ar")} عرض، مع بطاقات واضحة للسعر والمتجر وتقييم العملاء وسبب الترشيح.
              </p>
            </div>
            <div className="flex w-fit items-center gap-1 rounded-md border border-slate-200 bg-white p-1">
              <SlidersHorizontal aria-hidden="true" size={17} className="mr-2 text-slate-500" />
              <SortButton active={sortMode === "recommended"} onClick={() => setSortMode("recommended")}>الأفضل</SortButton>
              <SortButton active={sortMode === "lowest-price"} onClick={() => setSortMode("lowest-price")}>الأرخص</SortButton>
              <SortButton active={sortMode === "highest-trust"} onClick={() => setSortMode("highest-trust")}>الأوثق</SortButton>
            </div>
          </div>

          {sortedProducts.length ? (
            <>
              <section className="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                {sortedProducts.map((product) => (
                  <ProductCard key={product.id} product={product} onBuy={(selectedProduct) => openCheckout(selectedProduct)} />
                ))}
              </section>

              {hasMore ? (
                <div className="flex justify-center">
                  <button
                    type="button"
                    onClick={loadMoreProducts}
                    disabled={isLoadingMore}
                    className="focus-ring rounded-md border border-slate-300 bg-white px-6 py-3 text-sm font-black text-slate-800 transition hover:border-slate-950 hover:bg-slate-50 disabled:cursor-wait disabled:opacity-60"
                  >
                    {isLoadingMore ? "جاري جلب عروض إضافية..." : `عرض المزيد من النتائج`}
                  </button>
                </div>
              ) : null}
            </>
          ) : (
            <section className="rounded-lg border border-slate-200 bg-white p-8 text-center">
              <Store aria-hidden="true" size={32} className="mx-auto text-slate-400" />
              <h2 className="mt-3 text-xl font-black text-slate-950">لم نجد عروضاً مناسبة الآن</h2>
              <p className="mt-2 text-sm font-semibold text-slate-600">جرّب كلمة بحث أوسع أو ابحث باسم المنتج بطريقة مختلفة.</p>
            </section>
          )}
        </section>
      </main>

      <CheckoutModal product={checkoutProduct} checkoutUrl={checkoutUrl} onClose={() => setCheckoutProduct(null)} />
    </>
  );
}

function HeroBadge({ label, value }: { label: string; value: string }) {
  return (
    <div className="rounded-md border border-white/10 bg-white/10 p-3">
      <p className="text-xs font-bold text-slate-300">{label}</p>
      <p className="mt-1 line-clamp-2 text-sm font-black leading-5 text-white">{value}</p>
    </div>
  );
}

function SpotlightMetric({ label, value }: { label: string; value: string }) {
  return (
    <div className="rounded-lg border border-slate-200 bg-[#f8fbfc] p-4">
      <p className="text-xs font-bold text-slate-500">{label}</p>
      <p className="mt-1 text-2xl font-black text-slate-950">{value}</p>
    </div>
  );
}

function InsightSignal({ icon, title, value, text }: { icon: ReactNode; title: string; value: string; text: string }) {
  return (
    <div className="glass-signal rounded-md p-3">
      <div className="flex items-center justify-between gap-3">
        <span className="flex h-9 w-9 items-center justify-center rounded-md bg-white/10 text-[#8beeff] ring-1 ring-white/10">
          {icon}
        </span>
        <span className="text-lg font-black text-white">{value}</span>
      </div>
      <p className="mt-3 text-xs font-black text-white">{title}</p>
      <p className="mt-1 text-xs font-semibold leading-5 text-slate-300">{text}</p>
    </div>
  );
}

function MatrixRow({ product, price, onBuy }: { product: RankedProduct; price: string; onBuy: () => void }) {
  return (
    <div className="grid gap-4 px-5 py-4 lg:grid-cols-[minmax(0,1.25fr)_1.2fr_auto] lg:items-center">
      <div className="flex min-w-0 items-center gap-3">
        <img src={product.image} alt={product.title} className="h-16 w-16 shrink-0 rounded-md object-cover" />
        <div className="min-w-0">
          <p className="text-xs font-bold text-[#07515b]">{product.storeName}</p>
          <h3 className="mt-1 line-clamp-2 text-sm font-black leading-5 text-slate-950">{product.title}</h3>
          <p className="mt-1 text-xs font-semibold text-slate-500">{price}</p>
        </div>
      </div>

      <div className="grid gap-3 sm:grid-cols-3">
        <MatrixMetric label="يناسبك" value={product.insight.matchScore} tone="cyan" />
        <MatrixMetric label="القيمة" value={product.insight.valueScore} tone="coral" />
        <MatrixMetric label="الثقة" value={product.merchantReliabilityScore} tone="green" />
      </div>

      <button
        type="button"
        onClick={onBuy}
        className="primary-action focus-ring flex items-center justify-center gap-2 rounded-md px-4 py-3 text-sm font-black text-white transition"
      >
        اختيار العرض
        <ChevronLeft aria-hidden="true" size={16} />
      </button>
    </div>
  );
}

function MatrixMetric({ label, value, tone }: { label: string; value: number; tone: "cyan" | "coral" | "green" }) {
  const color = tone === "cyan" ? "#00cfe8" : tone === "coral" ? "#ff5a5f" : "#10b981";

  return (
    <div>
      <div className="flex items-center justify-between text-xs font-bold text-slate-500">
        <span>{label}</span>
        <span>{value}%</span>
      </div>
      <div className="mt-2 h-2 overflow-hidden rounded-full bg-slate-100">
        <div className="h-full rounded-full transition-all duration-700" style={{ width: `${Math.min(100, Math.max(0, value))}%`, background: color }} />
      </div>
    </div>
  );
}

function DecisionTile({ icon, title, product, value }: { icon: ReactNode; title: string; product?: RankedProduct; value: string }) {
  return (
    <div className="rounded-lg border border-slate-200 bg-slate-50 p-4">
      <div className="flex items-center justify-between gap-3">
        <span className="flex h-9 w-9 items-center justify-center rounded-md bg-white text-[#07515b] ring-1 ring-slate-200">
          {icon}
        </span>
        <span className="rounded-md bg-white px-2 py-1 text-xs font-black text-slate-700 ring-1 ring-slate-200">{value}</span>
      </div>
      <p className="mt-4 text-xs font-bold text-slate-500">{title}</p>
      <p className="mt-1 line-clamp-2 min-h-10 text-sm font-black leading-5 text-slate-950">
        {product?.title ?? "لا توجد بيانات كافية"}
      </p>
      {product ? (
        <p className="mt-2 text-xs font-semibold text-slate-600">
          {product.storeName} · تقييم {product.storeRating.toFixed(1)}
        </p>
      ) : null}
    </div>
  );
}

function DecisionFactor({ icon, title, text }: { icon: ReactNode; title: string; text: string }) {
  return (
    <div className="rounded-lg border border-slate-200 bg-slate-50 p-4">
      <span className="flex h-9 w-9 items-center justify-center rounded-md bg-white text-[#07515b] ring-1 ring-slate-200">
        {icon}
      </span>
      <h3 className="mt-3 text-sm font-black text-slate-950">{title}</h3>
      <p className="mt-2 text-sm font-semibold leading-6 text-slate-600">{text}</p>
    </div>
  );
}

function SignalBar({ label, value }: { label: string; value: number }) {
  return (
    <div>
      <div className="flex items-center justify-between text-xs font-bold text-slate-300">
        <span>{label}</span>
        <span>{value}%</span>
      </div>
      <div className="mt-2 h-2 overflow-hidden rounded-full bg-white/10">
        <div className="h-full rounded-full bg-[#00cfe8] transition-all duration-700" style={{ width: `${Math.min(100, Math.max(0, value))}%` }} />
      </div>
    </div>
  );
}

function DarkMetric({ label, value }: { label: string; value: string }) {
  return (
    <div className="rounded-md bg-white/10 p-3">
      <p className="text-xs font-bold text-slate-300">{label}</p>
      <p className="mt-1 text-lg font-black text-white">{value}</p>
    </div>
  );
}

function SortButton({ active, onClick, children }: { active: boolean; onClick: () => void; children: ReactNode }) {
  return (
    <button
      type="button"
      onClick={onClick}
      className={
        active
          ? "primary-action focus-ring rounded-md px-3 py-2 text-xs font-black text-white"
          : "focus-ring rounded-md px-3 py-2 text-xs font-bold text-slate-600 transition hover:bg-slate-50 hover:text-slate-950"
      }
    >
      {children}
    </button>
  );
}

function MiniMetric({ label, value }: { label: string; value: string }) {
  return (
    <div className="rounded-md bg-white p-2 ring-1 ring-slate-200">
      <p className="text-xs font-semibold text-slate-500">{label}</p>
      <p className="mt-1 text-sm font-black text-slate-950">{value}</p>
    </div>
  );
}
