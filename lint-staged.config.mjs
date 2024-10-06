/**
 * @type {import('lint-staged').Config}
 */
const config = {
  '*.{ts,mjs}': 'pnpm lint',
  '*': 'pnpm format',
}

export default config
