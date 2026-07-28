// @ts-check
const { defineConfig, devices } = require('@playwright/test');

/**
 * Playwright config for the CodeSommet tools audit.
 * Runs against the local `php artisan serve` instance.
 */
module.exports = defineConfig({
    testDir: './tests/browser',
    testMatch: '**/*.spec.cjs',
    timeout: 90_000,
    expect: { timeout: 15_000 },
    fullyParallel: false,
    workers: 1,
    retries: 0,
    reporter: [
        ['list'],
        ['json', { outputFile: 'tests/browser/.results/report.json' }],
    ],
    use: {
        baseURL: process.env.BASE_URL || 'http://127.0.0.1:8000',
        actionTimeout: 15_000,
        navigationTimeout: 45_000,
        ignoreHTTPSErrors: true,
        screenshot: 'only-on-failure',
    },
    projects: [
        {
            name: 'desktop',
            use: { ...devices['Desktop Chrome'], viewport: { width: 1440, height: 900 } },
        },
        {
            name: 'mobile',
            use: { ...devices['Desktop Chrome'], viewport: { width: 390, height: 844 }, isMobile: false, hasTouch: true },
        },
    ],
});
