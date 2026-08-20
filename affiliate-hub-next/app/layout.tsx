import type { Metadata } from "next";
import Link from "next/link";
import "./globals.css";

export const metadata: Metadata = {
  title: {
    default: "SmartStore AI | أفضل العروض من متاجر موثوقة",
    template: "%s | SmartStore AI",
  },
  description: "قارن المنتجات والعروض من متاجر موثوقة، واعرف أفضل خيار قبل الشراء.",
};

export default function RootLayout({ children }: Readonly<{ children: React.ReactNode }>) {
  return (
    <html lang="ar" dir="rtl">
      <body className="min-h-screen antialiased">
        <div className="site-signal-backdrop" aria-hidden="true">
          <div className="site-signal-lane site-signal-lane-start">
            <span className="site-signal-pulse" />
            <span className="site-signal-pulse" />
            <span className="site-signal-pulse" />
          </div>
          <div className="site-signal-lane site-signal-lane-end">
            <span className="site-signal-pulse" />
            <span className="site-signal-pulse" />
            <span className="site-signal-pulse" />
          </div>
          <div className="site-flow-lines site-flow-lines-start">
            <span />
            <span />
            <span />
          </div>
          <div className="site-flow-lines site-flow-lines-end">
            <span />
            <span />
            <span />
          </div>
          <div className="site-signal-beam site-signal-beam-one" />
          <div className="site-signal-beam site-signal-beam-two" />
        </div>
        {children}
        <footer className="border-t border-slate-200 bg-white">
          <div className="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-6 text-sm font-semibold text-slate-600 sm:px-6 lg:px-8">
            <div className="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
              <p className="max-w-3xl leading-7">
                نساعدك في مقارنة العروض من متاجر شريكة موثوقة. قد تحتوي بعض الروابط على شراكة تسويقية بدون أي تكلفة إضافية عليك.
              </p>
              <nav className="flex flex-wrap gap-3 text-sm font-black text-slate-800">
                <Link className="transition hover:text-[#07515b]" href="/terms">
                  شروط الاستخدام
                </Link>
                <Link className="transition hover:text-[#07515b]" href="/privacy">
                  سياسة الخصوصية
                </Link>
                <Link className="transition hover:text-[#07515b]" href="/partners">
                  المتاجر الشريكة
                </Link>
              </nav>
            </div>
            <p className="text-xs text-slate-500">SmartStore AI © 2026</p>
          </div>
        </footer>
      </body>
    </html>
  );
}
