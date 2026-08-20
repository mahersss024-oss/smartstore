# Render Deployment

This app is configured for Render as a Node web service because it uses API routes and server rendering.

## Blueprint

Use the `render.yaml` file in the repository root. It points Render to this subfolder:

```yaml
rootDir: affiliate-hub-next
```

## Manual Settings

If creating the service manually in Render:

- Runtime: `Node`
- Root Directory: `affiliate-hub-next`
- Build Command: `npm ci && npm run build`
- Start Command: `npm start`
- Health Check Path: `/`

## Environment Variables

Set these in Render:

```txt
NEXT_PUBLIC_AFFILIATE_API_URL=your_affiliate_network_data_feed_url
NEXT_PUBLIC_EMBED_CHECKOUT=true
AFFILIATE_SUBID_PARAM=subid
DATABASE_URL=provided automatically by Render PostgreSQL when using render.yaml
POSTBACK_SECRET=provided automatically by render.yaml
DEEPSEEK_API_URL=https://api.api.deepseek.com/v1
DEEPSEEK_API_KEY=your_deepseek_private_api_key
AI_MODEL_NAME=deepseek-chat
```

Keep `DEEPSEEK_API_KEY` private.

## Database

The Blueprint provisions a Render PostgreSQL database and injects `DATABASE_URL` into the web service.

The deploy runs:

```txt
npm run db:push
```

This creates the click-tracking table used by `/go/[productId]`.

## Conversion Postback

Use this endpoint with your affiliate network:

```txt
https://your-domain.com/api/conversions/postback?token=POSTBACK_SECRET&subid={subid}&order_id={order_id}&order_value={order_value}&commission={commission}&currency={currency}&status=approved&network=network_name
```

The endpoint also accepts `click_id`, `clickId`, or `sub_id` instead of `subid`.
