export const metadata = {
  title: "المتاجر الشريكة",
  description: "كيف تعمل عروض المتاجر الشريكة داخل SmartStore AI.",
};

export default function PartnersPage() {
  return (
    <main className="min-h-screen bg-[var(--canvas)] px-4 py-10">
      <article className="mx-auto max-w-3xl rounded-lg border border-slate-200 bg-white p-6">
        <h1 className="text-3xl font-black text-slate-950">المتاجر الشريكة</h1>
        <p className="mt-4 text-sm font-semibold leading-7 text-slate-600">
          نعرض عروضًا من متاجر وشبكات شريكة لمساعدتك على مقارنة السعر وجودة العرض وموثوقية التاجر قبل الشراء.
        </p>
        <div className="mt-6 grid gap-4 sm:grid-cols-3">
          <Card title="مقارنة واضحة" text="نعرض السعر، التاجر، الشحن، وسياسة الإرجاع عندما تكون متاحة." />
          <Card title="اختيار أفضل" text="نرتب العروض حسب السعر، الثقة، والتقييمات." />
          <Card title="شراء من المتجر" text="يتم تنفيذ الطلب عبر المتجر الشريك المسؤول عن الدفع والشحن." />
        </div>
      </article>
    </main>
  );
}

function Card({ title, text }: { title: string; text: string }) {
  return (
    <div className="rounded-lg bg-slate-50 p-4">
      <h2 className="text-sm font-black text-slate-950">{title}</h2>
      <p className="mt-2 text-sm font-semibold leading-6 text-slate-600">{text}</p>
    </div>
  );
}
