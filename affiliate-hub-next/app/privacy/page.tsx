export const metadata = {
  title: "سياسة الخصوصية",
  description: "كيف نتعامل مع بيانات البحث والنقرات لتحسين تجربة مقارنة العروض.",
};

export default function PrivacyPage() {
  return <LegalPage title="سياسة الخصوصية" sections={sections} />;
}

const sections = [
  {
    title: "ما البيانات التي نستخدمها؟",
    text: "نستخدم كلمات البحث، العروض التي يتم فتحها، مصدر الزيارة، وبعض بيانات الأداء لتحسين ترتيب العروض وتجربة المستخدم.",
  },
  {
    title: "لماذا نستخدم البيانات؟",
    text: "نستخدم البيانات لمعرفة العروض الأكثر فائدة، تحسين التوصيات، قياس أداء الحملات، ومنع إساءة الاستخدام.",
  },
  {
    title: "الشراء والدفع",
    text: "لا نعالج بيانات الدفع داخل منصتنا. يتم الدفع والشحن وخدمة ما بعد البيع عبر المتجر الشريك.",
  },
  {
    title: "حماية البيانات",
    text: "نحتفظ بالبيانات التشغيلية الضرورية فقط ونستخدمها لتحسين الخدمة وقياس الأداء.",
  },
];

function LegalPage({ title, sections }: { title: string; sections: Array<{ title: string; text: string }> }) {
  return (
    <main className="min-h-screen bg-[var(--canvas)] px-4 py-10">
      <article className="mx-auto max-w-3xl rounded-lg border border-slate-200 bg-white p-6">
        <h1 className="text-3xl font-black text-slate-950">{title}</h1>
        <div className="mt-6 space-y-5">
          {sections.map((section) => (
            <section key={section.title}>
              <h2 className="text-lg font-black text-slate-950">{section.title}</h2>
              <p className="mt-2 text-sm font-semibold leading-7 text-slate-600">{section.text}</p>
            </section>
          ))}
        </div>
      </article>
    </main>
  );
}
