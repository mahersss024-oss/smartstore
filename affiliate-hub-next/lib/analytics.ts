import { prisma } from "@/lib/db";

export type AnalyticsSnapshot = {
  databaseReady: boolean;
  totalClicks: number;
  totalConversions: number;
  approvedConversions: number;
  totalCommission: number;
  topProducts: Array<{ productId: string; productTitle: string; clicks: number }>;
  topStores: Array<{ storeName: string; clicks: number }>;
  topSources: Array<{ source: string; clicks: number }>;
  recentConversions: Array<{
    clickId: string;
    network: string;
    orderValue: number;
    commissionValue: number;
    currency: string;
    status: string;
    createdAt: string;
  }>;
};

export async function getAnalyticsSnapshot(): Promise<AnalyticsSnapshot> {
  if (!process.env.DATABASE_URL) {
    return {
      databaseReady: false,
      totalClicks: 0,
      totalConversions: 0,
      approvedConversions: 0,
      totalCommission: 0,
      topProducts: [],
      topStores: [],
      topSources: [],
      recentConversions: [],
    };
  }

  const [
    totalClicks,
    totalConversions,
    approvedConversions,
    commission,
    topProductGroups,
    topStoreGroups,
    topSourceGroups,
    recentConversions,
  ] = await Promise.all([
    prisma.affiliateClick.count(),
    prisma.affiliateConversion.count(),
    prisma.affiliateConversion.count({ where: { status: { in: ["approved", "paid"] } } }),
    prisma.affiliateConversion.aggregate({
      where: { status: { in: ["approved", "paid"] } },
      _sum: { commissionValue: true },
    }),
    prisma.affiliateClick.groupBy({
      by: ["productId", "productTitle"],
      _count: { _all: true },
      orderBy: { _count: { productId: "desc" } },
      take: 5,
    }),
    prisma.affiliateClick.groupBy({
      by: ["storeName"],
      _count: { _all: true },
      orderBy: { _count: { storeName: "desc" } },
      take: 5,
    }),
    prisma.affiliateClick.groupBy({
      by: ["source"],
      _count: { _all: true },
      orderBy: { _count: { source: "desc" } },
      take: 5,
    }),
    prisma.affiliateConversion.findMany({
      orderBy: { createdAt: "desc" },
      take: 8,
    }),
  ]);

  return {
    databaseReady: true,
    totalClicks,
    totalConversions,
    approvedConversions,
    totalCommission: commission._sum.commissionValue ?? 0,
    topProducts: topProductGroups.map((item) => ({
      productId: item.productId,
      productTitle: item.productTitle,
      clicks: item._count._all,
    })),
    topStores: topStoreGroups.map((item) => ({
      storeName: item.storeName,
      clicks: item._count._all,
    })),
    topSources: topSourceGroups.map((item) => ({
      source: item.source,
      clicks: item._count._all,
    })),
    recentConversions: recentConversions.map((item) => ({
      clickId: item.clickId,
      network: item.network,
      orderValue: item.orderValue,
      commissionValue: item.commissionValue,
      currency: item.currency,
      status: item.status,
      createdAt: item.createdAt.toISOString(),
    })),
  };
}
