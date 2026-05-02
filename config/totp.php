<?php
/**
 * Simple TOTP (Time-based One-Time Password) implementation for Google Authenticator.
 * Implements RFC 6238 in vanilla PHP.
 */
class TOTP {
    
    private static $base32chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    /**
     * Generate a random Base32 secret key (16 chars = 80 bits)
     */
    public static function generateSecret($length = 16) {
        $secret = '';
        for ($i = 0; $i < $length; $i++) {
            $secret .= self::$base32chars[random_int(0, 31)];
        }
        return $secret;
    }

    /**
     * Decode a Base32-encoded string to binary
     */
    private static function base32Decode($input) {
        $input = strtoupper($input);
        $buffer = 0;
        $bitsLeft = 0;
        $output = '';

        for ($i = 0; $i < strlen($input); $i++) {
            $pos = strpos(self::$base32chars, $input[$i]);
            if ($pos === false) continue;
            $buffer = ($buffer << 5) | $pos;
            $bitsLeft += 5;
            if ($bitsLeft >= 8) {
                $bitsLeft -= 8;
                $output .= chr(($buffer >> $bitsLeft) & 0xFF);
            }
        }
        return $output;
    }

    /**
     * Generate a TOTP code for the given secret at the current time
     */
    public static function getCode($secret, $timeSlice = null) {
        if ($timeSlice === null) {
            $timeSlice = floor(time() / 30);
        }

        $secretKey = self::base32Decode($secret);

        // Pack time into 8-byte binary (big-endian)
        $time = pack('N*', 0, $timeSlice);

        // HMAC-SHA1
        $hmac = hash_hmac('sha1', $time, $secretKey, true);

        // Dynamic truncation
        $offset = ord($hmac[19]) & 0x0F;
        $code = (
            ((ord($hmac[$offset]) & 0x7F) << 24) |
            ((ord($hmac[$offset + 1]) & 0xFF) << 16) |
            ((ord($hmac[$offset + 2]) & 0xFF) << 8) |
            (ord($hmac[$offset + 3]) & 0xFF)
        ) % 1000000;

        return str_pad($code, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Verify a user-supplied code against the secret.
     * Allows 1 time step drift (30 seconds before/after).
     */
    public static function verifyCode($secret, $code) {
        $currentTimeSlice = floor(time() / 30);
        for ($i = -1; $i <= 1; $i++) {
            if (self::getCode($secret, $currentTimeSlice + $i) === $code) {
                return true;
            }
        }
        return false;
    }

    /**
     * Generate the otpauth:// URI for Google Authenticator QR code
     */
    public static function getQRCodeUrl($label, $secret, $issuer = 'BullGym') {
        $uri = "otpauth://totp/" . urlencode($issuer . ':' . $label) 
             . "?secret=" . $secret 
             . "&issuer=" . urlencode($issuer)
             . "&digits=6&period=30";
        return "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($uri);
    }
}
?>
