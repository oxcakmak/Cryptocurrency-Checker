<?php
class cryptoChecker{
    protected $status;
    protected $coin;
    protected $message;
    protected $data = array();
    public function __construct(){
        $this->status = false;
    }
    /*
     * Custom Functions
    */
    /* BASE58 DECODE */
    function base58_decode($input) {
        $alphabet = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";
        $base_count = strlen($alphabet);
        $strlen = strlen($input);
        $num = "0";
        $leading_zeros = 0;
        for ($i = 0; $i < $strlen; $i++) {
            $current = strpos($alphabet, $input[$i]);
            $num = bcadd(bcmul($num, $base_count), $current);
            if ($input[$i] == "1") {
                $leading_zeros++;
            } else {
                $leading_zeros = 0;
            }
        }
        $bytes = array();
        while ($num >= 16) {
            $div = bcdiv($num, "256");
            array_push($bytes, bcmod($num, "256"));
            $num = $div;
        }
        array_push($bytes, $num);
        for ($i = 0; $i < $leading_zeros; $i++) {
            array_push($bytes, 0);
        }
        return implode(array_reverse($bytes));
    }

    public function set($status, $coin){
        $this->status = $status;
        $this->coin = $coin;
    }
    public function jsonOutput(){
        $this->data['status'] = $this->status;
        $this->data['coin'] = $this->coin;
        return json_encode($this->data, JSON_UNESCAPED_UNICODE);
    }
    public function check($address){
        $address = strtolower($address);
        
        /* BITCOIN-BTC */
        if (preg_match('/^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$/', $address)) {
            $decoded = $this->base58_decode($address);
            $d1 = hash("sha256", substr($decoded,0,21), true);
            $d2 = hash("sha256", $d1, true);
            if(substr_compare($decoded, $d2, 21, 4)){ $this->status = false; }
            $this->status = true;
            $this->coin = "CURRENCY";
        }
        /* BITCOIN_CASH-BCH */
        if (preg_match('/^[qQpP]{1}[a-zA-HJ-NP-Z0-9]{41}$/', $address)) {
            $this->status = true;
            $this->coin = "BCH";
        }
        /* BINANCE_COIN-BNB */
        if (preg_match('/^bnb1[0-9a-z]{38}$/i', $address)) {
            $this->status = true;
            $this->coin = "BNB";
        }
        /* CARDANO-ADA */
        if (preg_match('/^addr1[a-zA-HJ-NP-Za-km-z0-9]{58}$/', $address)) {
            $this->status = true;
            $this->coin = "ADA";
        }
        /* DOGECOIN-DOGE */
        if (preg_match('/^[D9][a-km-zA-HJ-NP-Z1-9]{26,34}$/', $address)) {
            $this->status = true;
            $this->coin = "DOGE";
        }
        /* ETHEREUM-ETH */
        if (preg_match('/^(0x)?[0-9a-fA-F]{40}$/', $address) || preg_match('/^(0x)?[0-9A-Fa-f]{40}$/', $address)) {
            $this->status = true;
            $this->coin = "ETH";
        }
        /* LITECOIN-LTC */
        if (preg_match('/^[LM3][a-km-zA-HJ-NP-Z1-9]{26,33}$/', $address)) {
            $this->status = true;
            $this->coin = "LTC";
        }
        /* MONERO-XMR */
        if (preg_match('/^4[0-9AB][1-9A-HJ-NP-Za-km-z]{93}$/', $address)) {
            $this->status = true;
            $this->coin = "XMR";
        }
        /* POLKADOT-DOT */
        if (preg_match('/^[1-9A-HJ-NP-Za-km-z]{47}$/', $address)) {
            $this->status = true;
            $this->coin = "DOT";
        }
        /* RIPPLE-XRP */
        if (preg_match('/^r[0-9a-zA-Z]{24,34}$/', $address) || strpos('rpshnaf39wBUDNEGHJKLM4PQRST7VWXYZ2', substr($address, 0, 1)) === true) {
            $this->status = true;
            $this->coin = "XRP";
        }
        /* SOLANA-SOL */
        if (preg_match('/^([1-9A-HJ-NP-Za-km-z]{32,33})$/', $address)) {
            $this->status = true;
            $this->coin = "SOL";
        }
        /* STELLAR-XLM */
        if (preg_match('/^G[a-zA-HJ-NP-Z0-9]{55}$/', $address)) {
            $this->status = true;
            $this->coin = "XLM";
        }        
        /* TETHER-USDT */
        if (preg_match('/^(0x)?[0-9a-fA-F]{40}$/', $address) || substr($address, 0, 2) == '0x' && substr($address, 0, 2) == 'OMN') {
            $this->status = true;
            $this->coin = "USDT";
        }
        /* TRON-TRX */
        if (preg_match('/^T[a-zA-HJ-NP-Za-km-z0-9]{33}$/', $address)) {
            $this->status = true;
            $this->coin = "TRX";
        }
        /* ZCASH-ZEC */
        if (preg_match('/^t[a-zA-Z0-9]{34}$/', $address)) {
            $this->status = true;
            $this->coin = "ZEC";
        }
        return $this->jsonOutput();
    }
}
?>
