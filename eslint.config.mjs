import globals from 'globals'
import pluginJs from '@eslint/js'
import tseslint from 'typescript-eslint'
import eslintPluginJest from 'eslint-plugin-jest'
import eslintPluginPrettier from 'eslint-plugin-prettier'
import { includeIgnoreFile } from '@eslint/compat'
import path from 'node:path'
import { fileURLToPath } from 'node:url'

const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)
const gitignorePath = path.resolve(__dirname, '.gitignore')

const languageOptions = { globals: { ...globals.browser, ...globals.node } }

export default [
  includeIgnoreFile(gitignorePath),
  { files: ['**/*.{mjs,ts}'], plugins: { prettier: eslintPluginPrettier } },
  { languageOptions: languageOptions },
  pluginJs.configs.recommended,
  {
    plugins: { jest: eslintPluginJest },
    rules: {
      ...eslintPluginJest.configs.recommended.rules,
    },
    files: ['**/*.test.ts'],
    languageOptions: {
      globals: {
        ...globals.jest,
      },
    },
  },
  ...tseslint.configs.recommended,
]
