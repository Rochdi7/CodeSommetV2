<?php

namespace Tests\Unit;

use App\Services\SafeUrlValidator;
use App\Services\UnsafeUrlException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SafeUrlValidatorTest extends TestCase
{
    private SafeUrlValidator $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new SafeUrlValidator();
    }

    public static function blockedIpProvider(): array
    {
        return [
            'ipv4 loopback' => ['127.0.0.1'],
            'ipv4 loopback range' => ['127.5.5.5'],
            'unspecified' => ['0.0.0.0'],
            'private 10/8' => ['10.0.0.1'],
            'private 172.16/12' => ['172.16.0.1'],
            'private 192.168/16' => ['192.168.1.1'],
            'link-local / metadata' => ['169.254.169.254'],
            'cgnat' => ['100.64.0.1'],
            'multicast' => ['224.0.0.1'],
            'reserved' => ['240.0.0.1'],
            'ipv6 loopback' => ['::1'],
            'ipv6 unspecified' => ['::'],
            'ipv6 unique-local' => ['fc00::1'],
            'ipv6 link-local' => ['fe80::1'],
            'ipv4-mapped loopback' => ['::ffff:127.0.0.1'],
        ];
    }

    #[DataProvider('blockedIpProvider')]
    public function test_private_and_reserved_ips_are_rejected(string $ip): void
    {
        $this->assertFalse($this->validator->isPublicIp($ip), "{$ip} should be blocked");
    }

    public static function publicIpProvider(): array
    {
        return [
            'google dns' => ['8.8.8.8'],
            'cloudflare' => ['1.1.1.1'],
            'public ipv6' => ['2606:4700:4700::1111'],
        ];
    }

    #[DataProvider('publicIpProvider')]
    public function test_public_ips_are_allowed(string $ip): void
    {
        $this->assertTrue($this->validator->isPublicIp($ip), "{$ip} should be allowed");
    }

    public static function unsafeUrlProvider(): array
    {
        return [
            'empty' => [''],
            'file scheme' => ['file:///etc/passwd'],
            'ftp scheme' => ['ftp://example.com'],
            'gopher scheme' => ['gopher://example.com'],
            'data scheme' => ['data:text/html,<script>1</script>'],
            'credentials' => ['http://user:pass@example.com'],
            'non-standard port' => ['http://example.com:22'],
            'loopback literal' => ['http://127.0.0.1'],
            'unspecified literal' => ['http://0.0.0.0'],
            'metadata literal' => ['http://169.254.169.254/latest/meta-data/'],
            'private literal' => ['http://10.0.0.1'],
            'ipv6 loopback literal' => ['http://[::1]'],
            'localhost name' => ['http://localhost'],
            'decimal ip' => ['http://2130706433'],
            'hex ip' => ['http://0x7f000001'],
            'octal-ish ip' => ['http://0177.0.0.1'],
            'internal tld' => ['http://service.internal'],
        ];
    }

    #[DataProvider('unsafeUrlProvider')]
    public function test_unsafe_urls_are_rejected(string $url): void
    {
        $this->expectException(UnsafeUrlException::class);
        $this->validator->validate($url);
    }

    public function test_valid_public_ip_url_passes(): void
    {
        // Literal public IP avoids DNS; still exercises the full validate() path.
        $result = $this->validator->validate('https://8.8.8.8');

        $this->assertSame('8.8.8.8', $result['host']);
        $this->assertContains('8.8.8.8', $result['ips']);
    }
}
