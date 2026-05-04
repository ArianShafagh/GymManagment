<?php
function isValid($token = null, $min_score = 0.5, $expected_action = null)
{
    try {
        if ($token === null) {
            if (!isset($_POST['g-recaptcha-response'])) return false;
            $token = $_POST['g-recaptcha-response'];
        }

        $secret_key = getenv('ENCRYPT_SECRET_KEY');
        if (!$secret_key || !$token) return false;

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = http_build_query([
            'secret'   => $secret_key,
            'response' => $token,
            'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
        ]);

        $opts = ['http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => $data,
            'timeout' => 5
        ]];

        $context  = stream_context_create($opts);
        $result = @file_get_contents($url, false, $context);
        if ($result === false) {
            error_log('Recaptcha verify: failed to contact Google');
            return false;
        }

        $decoded = json_decode($result, true);
        if (!$decoded || empty($decoded['success'])) return false;

        // If score is present (v3), enforce minimum score
        if (isset($decoded['score'])) {
            $score = floatval($decoded['score']);
            if ($score < floatval($min_score)) {
                error_log("Recaptcha verify: low score $score (min $min_score)");
                return false;
            }
        }

        // If action is provided, ensure it matches v3 action
        if ($expected_action !== null && isset($decoded['action'])) {
            if ($decoded['action'] !== $expected_action) {
                error_log('Recaptcha verify: action mismatch '.($decoded['action'] ?? ''));
                return false;
            }
        }

        return true;
    } catch (Exception $e) {
        error_log('Recaptcha verify exception: ' . $e->getMessage());
        return false;
    }
}

?>