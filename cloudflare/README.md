Metaserver hosted at Cloudflare using D1 storage.

To deploy, first create a Cloudflare account and install node.js locally, then

```
npx wrangler login        # opens a browser to authorize
npx wrangler d1 create metaserver   # copy the database_id into wrangler.toml
npx wrangler d1 execute metaserver --remote --file=schema.sql
npx wrangler d1 execute metaserver --remote --file=database_dump.sql
npx wrangler deploy
```
