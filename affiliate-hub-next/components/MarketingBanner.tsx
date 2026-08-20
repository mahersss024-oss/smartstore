import { BadgeCheck, Clock3, Sparkles } from "lucide-react";

type Props = {
  copy: string;
  isLoading: boolean;
};

export function MarketingBanner({ copy, isLoading }: Props) {
  return (
    <section className="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
      <div className="grid gap-0 lg:grid-cols-[1fr_auto]">
        <div className="flex gap-3 bg-[#00cfe8]/10 px-4 py-4 sm:px-5">
          <div className="brand-mark flex h-11 w-11 shrink-0 items-center justify-center rounded-md text-white">
            <Sparkles aria-hidden="true" size={21} />
          </div>
          <div>
            <p className="text-xs font-black text-[#07515b]">تنبيه عرض مناسب</p>
            <p className="mt-1 text-lg font-black leading-8 text-slate-950">
              {isLoading ? "نقارن السعر وجودة العرض لاختيار الأفضل لك..." : copy}
            </p>
          </div>
        </div>

        <div className="flex flex-wrap items-center gap-2 border-t border-slate-100 bg-white px-4 py-3 text-xs font-bold text-slate-700 lg:border-r lg:border-t-0 sm:px-5">
          <span className="flex items-center gap-1 rounded-md bg-[#10b981]/10 px-3 py-2 text-[#066348]">
            <BadgeCheck aria-hidden="true" size={15} />
            مبني على بيانات العرض
          </span>
          <span className="flex items-center gap-1 rounded-md bg-[#ff5a5f]/10 px-3 py-2 text-[#a8322d]">
            <Clock3 aria-hidden="true" size={15} />
            يتغير حسب البحث
          </span>
        </div>
      </div>
    </section>
  );
}
