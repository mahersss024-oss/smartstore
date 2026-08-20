export function buildGoUrl(productId: string, options?: { source?: string; campaign?: string; q?: string }): string {
  const params = new URLSearchParams();
  if (options?.source) params.set("source", options.source);
  if (options?.campaign) params.set("campaign", options.campaign);
  if (options?.q) params.set("q", options.q);

  const query = params.toString();
  return `/go/${encodeURIComponent(productId)}${query ? `?${query}` : ""}`;
}
