<?php


class Masteryl_Jwt
{
    use Masteryl_StrToNum;

    protected $secret;

    protected $age;

    protected $token; // after validate stored

    protected $payload; // stored after validate

    public function __construct($secret = 'secret', $age = '24h')
    {
        $this->secret = $secret;
        $this->age = $age;
    }

    public function open($key = null, $def = false)
    {
        if ($key) {
            return !empty($this->payload->{$key}) ? $this->payload->{$key} : $def;
        }
        return $this->payload;
    }

    public static function create($payload = [], $secret = null, $age = null)
    {
        $self = new static($secret, $age);
        return $self->_create($payload);
    }

    // return false or object
    public static function validate($token, $secret = null, $age = null)
    {
        $self = new static($secret, $age);
        return $self->_validate($token);
    }

    private function _validate($token)
    {
        if (empty($token) || strpos($token, '.') < 0) {
            return false;
        }

        // split the token
        $part = explode('.', $token);

        if (count($part) < 3) {
            return false;
        }

        $payload = base64_decode($part[1]);

        // time left

        if ((json_decode($payload)->exp - current_time('U')) < 0) {
            return false;
        }

        $signatureProvided = $part[2];

        $header = base64_decode($part[0]);

        $base64UrlHeader = $this->base64UrlEncode($header);

        $base64UrlPayload = $this->base64UrlEncode($payload);

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->secret, true);

        $base64UrlSignature = $this->base64UrlEncode($signature);

        if ($base64UrlSignature === $signatureProvided) {
            $this->payload = json_decode($payload);
            $this->token = $token;
            return $this;
        }
        return false;
    }

    // returns token
    private function _create($payload = [])
    {

        // set header
        $header = json_encode([
            'typ' => 'JWT',
            'alg' => 'HS256',
        ]);

        // // Create the token payload

        $payload['exp'] = $this->strToNum($this->age, true);

        $payload = json_encode($payload);

        // // Encode Header
        $base64UrlHeader = $this->base64UrlEncode($header);

        // // Encode Payload
        $base64UrlPayload = $this->base64UrlEncode($payload);

        // // Create Signature Hash
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->secret, true);

        // // Encode Signature to Base64Url String
        $base64UrlSignature = $this->base64UrlEncode($signature);

        // // Create JWT
        $this->token = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        return $this->token;
    }

    private function base64UrlEncode($text)
    {
        return str_replace(
            ['+', '/', '='],
            ['-', '_', ''],
            base64_encode($text)
        );
    }
}
