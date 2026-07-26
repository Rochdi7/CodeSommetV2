<?php

namespace App\Services;

use App\Models\Payment;

/**
 * Generates unique, monotonic invoice numbers.
 *
 * The sequence is derived from the MAX existing suffix for a given prefix
 * (NOT a row COUNT, which is not monotonic under deletion), so numbers are
 * never reused after a payment is deleted. Generation is expected to run
 * inside a DB transaction; a unique index on `payments.invoice_number`
 * provides the final guarantee, and callers retry on the rare conflict.
 */
class InvoiceNumberGenerator
{
    private const MONTHS = ['', 'JAN', 'FEV', 'MAR', 'AVR', 'MAI', 'JUN', 'JUL', 'AOU', 'SEP', 'OCT', 'NOV', 'DEC'];

    /**
     * Build the next invoice number for the given billing period.
     * Format preserved from the original implementation:
     *   monthly   "2026-03" → INV-2026-MAR-001
     *   quarterly "2026-Q2" → INV-2026-Q2-001
     *   other     "2026"    → INV-2026-AN-001
     *   one-time            → INV-<year>-001
     */
    public function next(?string $billingPeriod, ?int $year = null): string
    {
        $year ??= (int) date('Y');
        $prefix = $this->prefixFor($billingPeriod, $year);

        $seq = $this->nextSequenceForPrefix($prefix);

        return $prefix . str_pad((string) $seq, 3, '0', STR_PAD_LEFT);
    }

    /**
     * The invoice-number prefix (everything before the 3-digit sequence),
     * including the trailing separator.
     */
    private function prefixFor(?string $billingPeriod, int $year): string
    {
        if ($billingPeriod) {
            if (preg_match('/^(\d{4})-(\d{2})$/', $billingPeriod, $m)) {
                $tag = $m[1] . '-' . (self::MONTHS[(int) $m[2]] ?? $m[2]);
            } elseif (preg_match('/^(\d{4})-(Q\d)$/', $billingPeriod, $m)) {
                $tag = $m[1] . '-' . $m[2];
            } else {
                $tag = $billingPeriod . '-AN';
            }

            return 'INV-' . $tag . '-';
        }

        return 'INV-' . $year . '-';
    }

    /**
     * Find the highest existing 3-digit sequence for a prefix and return the
     * next value. Falls back to scanning all matching rows (SQLite has no
     * REGEXP by default), which is fine at this table's scale.
     */
    private function nextSequenceForPrefix(string $prefix): int
    {
        $max = 0;
        $rows = Payment::query()
            ->where('invoice_number', 'like', $prefix . '%')
            ->pluck('invoice_number');

        foreach ($rows as $inv) {
            $suffix = substr((string) $inv, strlen($prefix));
            if (preg_match('/^(\d{1,})/', $suffix, $m)) {
                $max = max($max, (int) $m[1]);
            }
        }

        return $max + 1;
    }
}
