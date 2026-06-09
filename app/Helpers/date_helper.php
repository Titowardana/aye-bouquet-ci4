<?php

if (!function_exists('formatTanggalIndo')) {
    function formatTanggalIndo($date)
    {
        if (empty($date) || $date === '-' || $date === '0000-00-00') {
            return '-';
        }
        $time = strtotime($date);
        return $time ? date('d-m-Y', $time) : '-';
    }
}

if (!function_exists('formatJamIndo')) {
    function formatJamIndo($time)
    {
        if (empty($time) || $time === '-' || $time === '00:00:00') {
            return '-';
        }
        $timestamp = strtotime($time);
        return $timestamp ? date('H:i', $timestamp) . ' WIB' : '-';
    }
}

if (!function_exists('formatDatetimeIndo')) {
    function formatDatetimeIndo($datetime)
    {
        if (empty($datetime) || $datetime === '-' || $datetime === '0000-00-00 00:00:00') {
            return '-';
        }
        $time = strtotime($datetime);
        if (!$time) {
            return '-';
        }
        return date('d-m-Y', $time) . ' ' . date('H:i', $time) . ' WIB';
    }
}

if (!function_exists('formatVariantDisplay')) {
    function formatVariantDisplay($ukuran, $warna)
    {
        $parts = [];
        if (!empty($ukuran) && $ukuran !== '-' && $ukuran !== '') {
            $parts[] = 'Ukuran: ' . $ukuran;
        }
        if (!empty($warna) && $warna !== '-' && $warna !== '') {
            $parts[] = 'Warna: ' . $warna;
        }
        return !empty($parts) ? implode(' • ', $parts) : '';
    }
}
