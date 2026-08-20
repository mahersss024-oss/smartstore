import type { Product, ProductOptionInsight, ProductRecognition, RankedProduct } from "@/lib/types";

const categoryKeywords: Array<{ category: string; keywords: string[] }> = [
  { category: "ساعات ذكية", keywords: ["ساعة", "ساعات", "watch", "smartwatch", "smart watch"] },
  { category: "سماعات", keywords: ["سماعة", "سماعات", "earbuds", "headphone", "audio"] },
  { category: "أجهزة منزلية", keywords: ["قلاية", "مطبخ", "air fryer", "home", "kitchen"] },
  { category: "جمال وعناية", keywords: ["بشرة", "عناية", "skin", "beauty", "care"] },
];

function normalizeText(value: string): string {
  return value
    .trim()
    .toLowerCase()
    .replace(/[إأآا]/g, "ا")
    .replace(/ة/g, "ه")
    .replace(/ى/g, "ي")
    .replace(/[^\p{L}\p{N}\s-]/gu, " ")
    .replace(/\s+/g, " ");
}

function keywordMatchScore(product: Product, normalizedQuery: string): number {
  if (!normalizedQuery) return 72;

  const searchable = normalizeText(
    [
      product.title,
      product.description,
      product.category,
      product.storeName,
      product.merchantName,
      product.pros.join(" "),
    ].join(" ")
  );

  const tokens = normalizedQuery.split(" ").filter(Boolean);
  const matchedTokens = tokens.filter((token) => searchable.includes(token)).length;
  const phraseBonus = searchable.includes(normalizedQuery) ? 18 : 0;

  return Math.min(100, Math.round((matchedTokens / Math.max(tokens.length, 1)) * 72 + phraseBonus));
}

function priceScore(product: Product, minPrice: number, maxPrice: number): number {
  if (!product.price) return 60;
  if (minPrice === maxPrice) return 88;

  const range = maxPrice - minPrice;
  return Math.round(100 - ((product.price - minPrice) / range) * 42);
}

function valueScore(product: Product, priceSignal: number): number {
  const availabilityScore = product.availability === "OutOfStock" ? 35 : product.availability === "LimitedAvailability" ? 84 : 92;
  return Math.round(
    priceSignal * 0.32 +
      product.merchantReliabilityScore * 0.18 +
      product.trustScore * 0.07 +
      product.rating * 10 * 0.18 +
      product.merchantCustomerRating * 10 * 0.1 +
      product.discountPercent * 0.15 +
      availabilityScore * 0.1
  );
}

function buildBadges(product: Product, rank: number, priceSignal: number): string[] {
  const badges: string[] = [];
  if (rank === 1) badges.push("أفضل خيار");
  if (priceSignal >= 92) badges.push("أفضل سعر");
  if (product.merchantReliabilityScore >= 94) badges.push("تاجر موثوق جدًا");
  if (product.storeRating >= 4.7) badges.push("متجر مميز");
  if (product.merchantCustomerRating >= 4.8) badges.push("تقييم عملاء مرتفع");
  if (product.discountPercent >= 25) badges.push("خصم قوي");
  if (product.availability === "LimitedAvailability") badges.push("كمية محدودة");
  return badges.slice(0, 4);
}

function bestFor(product: Product, priceSignal: number): string {
  if (priceSignal >= 92 && product.merchantReliabilityScore >= 90) return "الأفضل لمن يريد أقل سعر من تاجر موثوق";
  if (product.merchantReliabilityScore >= 94) return "الأفضل لمن يعطي الأولوية لموثوقية التاجر وتقييم العملاء";
  if (product.discountPercent >= 25) return "الأفضل لمن يبحث عن خصم واضح وقيمة عالية";
  return "خيار متوازن بين السعر والتقييم والتوفر";
}

export function recognizeProductIntent(query: string, products: Product[]): ProductRecognition {
  const normalizedQuery = normalizeText(query);
  const allText = normalizeText(products.map((product) => `${product.title} ${product.category}`).join(" "));
  const matchedCategory = categoryKeywords.find((item) =>
    item.keywords.some((keyword) => normalizedQuery.includes(normalizeText(keyword)) || allText.includes(normalizeText(keyword)))
  );

  const hasDealWords = ["رخيص", "ارخص", "افضل", "عرض", "خصم", "best", "cheap", "deal"].some((word) =>
    normalizedQuery.includes(normalizeText(word))
  );
  const detectedIntent =
    normalizedQuery.length > 12 && products.some((product) => normalizeText(product.title).includes(normalizedQuery))
      ? "exact-product"
      : hasDealWords
        ? "deal-search"
        : matchedCategory
          ? "category-search"
          : "general-search";

  const confidence = products.length
    ? Math.min(98, Math.max(62, Math.round(products.reduce((sum, product) => sum + keywordMatchScore(product, normalizedQuery), 0) / products.length)))
    : 35;

  const detectedCategory = matchedCategory?.category ?? products[0]?.category ?? "منتجات متنوعة";

  return {
    query,
    normalizedQuery,
    detectedCategory,
    detectedIntent,
    confidence,
    summary: products.length
      ? `تم التعرف على البحث كطلب ضمن فئة ${detectedCategory}، وتمت مقارنة ${products.length} خيارًا حسب السعر والثقة والتوفر.`
      : "لم نعثر على خيارات كافية لهذا البحث بعد. جرّب كلمة أوسع أو اربط مصدر منتجات أكبر.",
    comparedSignals: ["السعر الحالي", "الخصم", "تقييم المنتج", "ثقة المتجر", "الشحن", "سياسة الإرجاع", "توفر المنتج"],
  };
}

export function rankProductOptions(products: Product[], query: string): RankedProduct[] {
  if (!products.length) return [];

  const normalizedQuery = normalizeText(query);
  const prices = products.map((product) => product.price).filter((price) => price > 0);
  const minPrice = Math.min(...prices);
  const maxPrice = Math.max(...prices);

  const scored = products
    .map((product) => {
      const productPriceScore = priceScore(product, minPrice, maxPrice);
      const productValueScore = valueScore(product, productPriceScore);
      const matchScore = keywordMatchScore(product, normalizedQuery);
      const total = Math.round(
        matchScore * 0.26 +
          productValueScore * 0.4 +
          product.merchantReliabilityScore * 0.18 +
          product.merchantCustomerRating * 10 * 0.08 +
          product.discountPercent * 0.08
      );

      return {
        product,
        total,
        matchScore,
        valueScore: productValueScore,
        priceScore: productPriceScore,
      };
    })
    .sort((a, b) => b.total - a.total);

  return scored.map((entry, index) => {
    const rank = index + 1;
    const insight: ProductOptionInsight = {
      productId: entry.product.id,
      rank,
      matchScore: entry.matchScore,
      valueScore: entry.valueScore,
      trustScore: entry.product.merchantReliabilityScore,
      priceScore: entry.priceScore,
      badges: buildBadges(entry.product, rank, entry.priceScore),
      bestFor: bestFor(entry.product, entry.priceScore),
      whyThisOption:
        rank === 1
          ? `أفضل خيار حاليًا لأنه يجمع بين سعر منافس وموثوقية تاجر ${entry.product.merchantReliabilityScore}% وتقييم عملاء ${entry.product.merchantCustomerRating.toFixed(1)} من 5.`
          : `خيار مناسب عند مقارنة السعر والتقييم، خصوصًا أن التاجر حاصل على موثوقية ${entry.product.merchantReliabilityScore}% و${entry.product.merchantReviewCount.toLocaleString("ar")} مراجعة.`,
    };

    return {
      ...entry.product,
      insight,
    };
  });
}
