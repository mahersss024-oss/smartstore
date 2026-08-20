export const categories = [
  {
    slug: "smart-watches",
    name: "ساعات ذكية",
    query: "ساعة ذكية",
    description: "قارن أفضل عروض الساعات الذكية من متاجر موثوقة حسب السعر والتقييم وموثوقية التاجر.",
  },
  {
    slug: "audio",
    name: "سماعات",
    query: "سماعات",
    description: "اكتشف أفضل عروض السماعات وسماعات الأذن مع تقييمات التجار وتفاصيل الشحن.",
  },
  {
    slug: "home-kitchen",
    name: "منزل ومطبخ",
    query: "قلاية هوائية",
    description: "قارن عروض الأجهزة المنزلية والمطبخ واختر أفضل قيمة قبل الشراء.",
  },
  {
    slug: "beauty",
    name: "جمال وعناية",
    query: "عناية بالبشرة",
    description: "اعثر على عروض العناية والجمال من متاجر موثوقة مع شرح واضح لقوة كل عرض.",
  },
];

export function getCategoryBySlug(slug: string) {
  return categories.find((category) => category.slug === slug);
}
