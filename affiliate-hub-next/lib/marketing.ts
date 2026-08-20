const systemPrompt =
  "You are an elite conversion rate optimization (CRO) copywriter for an Arabic shopping comparison platform. The user just searched for a product. Output a short, urgent, persuasive Arabic marketing hook, maximum 2 sentences. Use only claims that can be supported by product data: price advantage, store trust, rating, shipping, scarcity, or value. Do not pretend we are the seller. Output raw persuasive text only, no conversational filler.";

type MarketingProductContext = {
  title: string;
  price: number;
  currency: string;
  discountPercent: number;
  storeName: string;
  merchantReliabilityScore: number;
  merchantCustomerRating: number;
  comparisonReason: string;
};

const MAX_MARKETING_PRODUCTS = 24;

export async function generateMarketingCopy(searchTerm: string, products: MarketingProductContext[] = []): Promise<string> {
  const query = searchTerm.trim();

  if (!query) {
    return "اكتشف أفضل العروض المختارة اليوم من متاجر شريكة موثوقة، وقارن السعر والجودة قبل الشراء.";
  }

  const apiKey = process.env.DEEPSEEK_API_KEY;
  const apiUrl = process.env.DEEPSEEK_API_URL ?? "https://api.api.deepseek.com/v1";
  const model = process.env.AI_MODEL_NAME ?? "deepseek-chat";

  if (!apiKey || apiKey.includes("your_deepseek")) {
    const bestProduct = products[0];
    if (bestProduct) {
      return `وجدنا لك ${bestProduct.title} بسعر ${bestProduct.price} ${bestProduct.currency} من ${bestProduct.storeName} مع موثوقية تاجر ${bestProduct.merchantReliabilityScore}%. راجع العرض الآن قبل تغيّر السعر أو نفاد الكمية.`;
    }
    return `وجدنا لك عروض ${query} من متاجر شريكة موثوقة مع مقارنة ذكية للسعر والجودة. راجع أفضل خيار الآن قبل تغيّر السعر أو نفاد الكمية.`;
  }

  const response = await fetch(`${apiUrl.replace(/\/$/, "")}/chat/completions`, {
    method: "POST",
    headers: {
      Authorization: `Bearer ${apiKey}`,
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      model,
      messages: [
        { role: "system", content: systemPrompt },
        {
          role: "user",
          content: JSON.stringify({
            searchTerm: query,
            shownOffers: products.slice(0, MAX_MARKETING_PRODUCTS),
          }),
        },
      ],
      temperature: 0.7,
      max_tokens: 120,
    }),
  });

  if (!response.ok) {
    throw new Error(`DeepSeek request failed: ${response.status}`);
  }

  const payload = await response.json();
  const copy = payload?.choices?.[0]?.message?.content;

  if (typeof copy !== "string" || !copy.trim()) {
    return `لا تفوّت مقارنة عروض ${query} اليوم؛ الأسعار والكميات لدى المتاجر الشريكة قد تتغير بسرعة.`;
  }

  return copy.trim();
}
