<?php

class VNPay
{

    private array $params = [];

    public function __construct(
        private string $secret = '',
        private string $tmnCode = '',
    )
    {
    }

    public static function make()
    {
        return new static(...func_get_args());
    }

    public function setParams(array $params): static
    {
        if (isset($params['vnp_Amount']) && is_numeric($params['vnp_Amount'])) {
            $params['vnp_Amount'] *= 100;// https://sandbox.vnpayment.vn/apis/docs/thanh-toan-pay/pay.html#danh-s%C3%A1ch-tham-s%E1%BB%91-1 x100 lần
        }
        if (!isset($params['vnp_CreateDate'])) {
            $params['vnp_CreateDate'] = (new Datetime(timezone:new DateTimeZone('Asia/Ho_Chi_Minh')))->format('YmdHis');
        }
        $this->params = $params;
        // Default params
        $this->params["vnp_Version"] = '2.1.0';
        $this->params["vnp_TmnCode"] = $this->tmnCode;
        $this->params["vnp_Command"] = 'pay';
        $this->params["vnp_CurrCode"] = 'VND';
        $this->params["vnp_IpAddr"] = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $this->params["vnp_Locale"] = 'vn';
        $this->params["vnp_OrderType"] = 'other';
        return $this;
    }

    public function purchase(): string
    {
        return $this->getHost() . '/paymentv2/vpcpay.html?' . $this->buildParams();
    }

    public function getHost(): string
    {
        return 'https://sandbox.vnpayment.vn';
    }

    public function buildParams(): string
    {
        $params = $this->params;
        ksort($params);
        $dataHash = http_build_query($params);
        $hashed = $this->makeHash($dataHash);
        return $dataHash . '&vnp_SecureHash=' . $hashed;
    }

    public function makeHash(string $data, string $secret = ''): string
    {
        return hash_hmac("sha512", $data, $secret ?: $this->secret);
    }

    public function checkTx(array $data): array
    {
        try {
            $input = [];
            foreach ($data as $key => $item) {
                if (str_starts_with($key, 'vnp_')) {
                    $input[$key] = $item;
                }
            }
            $secureHash = $input['vnp_SecureHash'];
            unset($input['vnp_SecureHash']);
            ksort($input);
            $dataHash = http_build_query($input);
            if ($secureHash !== $this->makeHash($dataHash)) {
                return [
                    'RspCode' => '97',
                    'Message' => 'Invalid signature'
                ];
            }
        } catch (Exception $e) {
            return [
                'RspCode' => '99',
                'Message' => 'Unknown error'
            ];
        }
        return [
            'RspCode' => '00',
            'Message' => 'Confirm Success'
        ];
    }
}
