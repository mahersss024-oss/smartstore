import { getAnalyticsSnapshot } from "@/lib/analytics";

export const dynamic = "force-dynamic";

export default async function InsightsPage() {
  const snapshot = await getAnalyticsSnapshot();
  const conversionRate = snapshot.totalClicks
    ? ((snapshot.totalConversions / snapshot.totalClicks) * 100).toFixed(1)
    : "0.0";

  return (
    <main className="min-h-screen bg-[var(--canvas)] px-4 py-8 sm:px-6 lg:px-8">
      <div className="mx-auto max-w-7xl space-y-6">
        <header className="rounded-lg border border-slate-200 bg-white p-6">
          <p className="text-sm font-black text-[#07515b]">لوحة الأداء</p>
          <h1 className="mt-2 text-3xl font-black text-slate-950">نتائج النقرات والمبيعات</h1>
          <p className="mt-2 max-w-2xl text-sm font-semibold leading-6 text-slate-600">
            هذه الصفحة تساعدك على معرفة المنتجات والمتاجر ومصادر الزيارات التي تحقق أفضل أداء.
          </p>
          {!snapshot.databaseReady ? (
            <div className="mt-4 rounded-md border border-amber-200 bg-amber-50 p-4 text-sm font-bold text-amber-900">
              قاعدة البيانات غير مفعلة محليًا. عند النشر على Render سيتم تفعيلها عبر PostgreSQL تلقائيًا.
            </div>
          ) : null}
        </header>

        <section className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
          <Metric title="النقرات" value={snapshot.totalClicks.toLocaleString("ar")} />
          <Metric title="عمليات الشراء المسجلة" value={snapshot.totalConversions.toLocaleString("ar")} />
          <Metric title="المبيعات المعتمدة" value={snapshot.approvedConversions.toLocaleString("ar")} />
          <Metric title="نسبة التحويل" value={`${conversionRate}%`} />
        </section>

        <section className="grid gap-4 lg:grid-cols-3">
          <Panel title="أكثر المنتجات اهتمامًا">
            {snapshot.topProducts.length ? (
              snapshot.topProducts.map((item) => <Row key={item.productId} label={item.productTitle} value={`${item.clicks} نقرة`} />)
            ) : (
              <Empty />
            )}
          </Panel>
          <Panel title="أفضل المتاجر جذبًا">
            {snapshot.topStores.length ? (
              snapshot.topStores.map((item) => <Row key={item.storeName} label={item.storeName} value={`${item.clicks} نقرة`} />)
            ) : (
              <Empty />
            )}
          </Panel>
          <Panel title="مصادر الزوار">
            {snapshot.topSources.length ? (
              snapshot.topSources.map((item) => <Row key={item.source} label={item.source} value={`${item.clicks} نقرة`} />)
            ) : (
              <Empty />
            )}
          </Panel>
        </section>

        <section className="rounded-lg border border-slate-200 bg-white p-5">
          <div className="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
              <p className="text-sm font-black text-slate-950">آخر عمليات الشراء المسجلة</p>
              <p className="mt-1 text-sm font-semibold text-slate-500">تظهر هنا التحويلات القادمة من شبكة الأفلييت.</p>
            </div>
            <p className="trust-chip rounded-md px-3 py-2 text-sm font-black">
              إجمالي العائد: {snapshot.totalCommission.toLocaleString("ar")} 
            </p>
          </div>

          <div className="mt-4 overflow-x-auto">
            <table className="w-full min-w-[720px] text-right text-sm">
              <thead>
                <tr className="border-b border-slate-200 text-xs font-black text-slate-500">
                  <th className="py-3">رقم التتبع</th>
                  <th className="py-3">الشبكة</th>
                  <th className="py-3">قيمة الطلب</th>
                  <th className="py-3">العائد</th>
                  <th className="py-3">الحالة</th>
                  <th className="py-3">التاريخ</th>
                </tr>
              </thead>
              <tbody>
                {snapshot.recentConversions.length ? (
                  snapshot.recentConversions.map((item) => (
                    <tr key={`${item.network}-${item.clickId}-${item.createdAt}`} className="border-b border-slate-100">
                      <td className="py-3 font-semibold text-slate-700">{item.clickId}</td>
                      <td className="py-3 font-semibold text-slate-700">{item.network}</td>
                      <td className="py-3 font-black text-slate-950">
                        {item.orderValue.toLocaleString("ar")} {item.currency}
                      </td>
                      <td className="py-3 font-black text-emerald-700">
                        {item.commissionValue.toLocaleString("ar")} {item.currency}
                      </td>
                      <td className="py-3 font-semibold text-slate-700">{item.status}</td>
                      <td className="py-3 font-semibold text-slate-500">{new Date(item.createdAt).toLocaleDateString("ar")}</td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td colSpan={6} className="py-8 text-center font-semibold text-slate-500">
                      لا توجد عمليات شراء مسجلة بعد.
                    </td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>
        </section>
      </div>
    </main>
  );
}

function Metric({ title, value }: { title: string; value: string }) {
  return (
    <div className="rounded-lg border border-slate-200 bg-white p-5">
      <p className="text-sm font-semibold text-slate-500">{title}</p>
      <p className="mt-2 text-3xl font-black text-slate-950">{value}</p>
    </div>
  );
}

function Panel({ title, children }: { title: string; children: React.ReactNode }) {
  return (
    <div className="rounded-lg border border-slate-200 bg-white p-5">
      <p className="text-sm font-black text-slate-950">{title}</p>
      <div className="mt-4 space-y-3">{children}</div>
    </div>
  );
}

function Row({ label, value }: { label: string; value: string }) {
  return (
    <div className="flex items-center justify-between gap-3 rounded-md bg-slate-50 p-3">
      <p className="line-clamp-1 text-sm font-bold text-slate-700">{label}</p>
      <p className="shrink-0 text-sm font-black text-slate-950">{value}</p>
    </div>
  );
}

function Empty() {
  return <p className="rounded-md bg-slate-50 p-4 text-sm font-semibold text-slate-500">لا توجد بيانات كافية بعد.</p>;
}
