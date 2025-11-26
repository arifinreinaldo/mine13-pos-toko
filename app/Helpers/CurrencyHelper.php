<?php

if (! function_exists('format_currency')) {
    /**
     * Format number to currency (IDR)
     *
     * @param  mixed  $amount
     * @return string
     */
    function format_currency($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
