<?php

// Very simple admin IP guard: read allowed IPs from a JSON file and check exact matches.

/**
 * Get the client's IP address (basic, checks common headers).
 */
function get_client_ip(): string
{
    $keys = ['HTTP_X_FORWARDED_FOR','HTTP_CLIENT_IP','REMOTE_ADDR'];
    foreach ($keys as $k) {
        if (!empty($_SERVER[$k])) {
            $val = $_SERVER[$k];
            if (strpos($val, ',') !== false) {
                $parts = explode(',', $val);
                return trim($parts[0]);
            }
            return trim($val);
        }
    }
    return '';
}

/**
 * Check whether the given IP is listed in the JSON allowlist.
 * The JSON file should be an array of strings, e.g. ["127.0.0.1","203.0.113.5"].
 */
function is_ip_allowed(string $ip): bool
{
    $file = __DIR__ . '/admin_allowed_ips.json';
    if (!file_exists($file)) return false;
    $raw = file_get_contents($file);
    if ($raw === false) return false;
    $list = json_decode($raw, true);
    if (!is_array($list)) return false;

    // Exact match (IPv4 or IPv6)
    foreach ($list as $entry) {
        if (!is_string($entry)) continue;
        if (trim($entry) === $ip) return true;
    }
    return false;
}

function check_admin_ip_or_die(): void
{
    $ip = get_client_ip();
    if ($ip === '' || !is_ip_allowed($ip)) {
        http_response_code(403);
        header('Content-Type: text/plain; charset=utf-8');
        echo "403 Forbidden - access restricted.\n";
        echo "Your IP: $ip\n";
        exit();
    }
}
