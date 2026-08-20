export const metadata = {
  title: "شروط الاستخدام",
  description: "شروط استخدام منصة مقارنة العروض والمتاجر الشريكة.",
};

export default function TermsPage() {
  return (
    <main className="min-h-screen bg-[var(--canvas)] px-4 py-10">
      <article className="mx-auto max-w-3xl rounded-lg border border-slate-200 bg-white p-6">
        <h1 className="text-3xl font-black text-slate-950">شروط الاستخدام</h1>
        <div className="mt-6 space-y-5">
          <Section title="طبيعة الخدمة" text="نساعدك على مقارنة العروض من متاجر شريكة واختيار الأنسب. نحن لا نبيع المنتجات مباشرة ولا ننفذ الدفع أو الشحن." />
          <Section title="دقة المعلومات" text="نحرص على عرض الأسعار والتفاصيل بناءً على البيانات المتاحة، لكن السعر والتوفر قد يتغيران لدى المتجر الشريك." />
          <Section title="إتمام الطلب" text="عند متابعة الشراء، يتم تنفيذ الطلب عبر المتجر الشريك وتطبق شروطه وسياساته على الدفع والشحن والاسترجاع." />
          <Section title="الاستخدام المقبول" text="يجب استخدام المنصة بطريقة نظامية وعدم محاولة إساءة استخدام روابط العروض أو أنظمة التتبع." />
        </div>
      </article>
    </main>
  );
}

function Section({ title, text }: { title: string; text: string }) {
  return (
    <section>
      <h2 className="text-lg font-black text-slate-950">{title}</h2>
      <p className="mt-2 text-sm font-semibold leading-7 text-slate-600">{text}</p>
    </section>
  );
}
