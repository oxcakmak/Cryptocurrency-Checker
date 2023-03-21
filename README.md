# Cryptocurrency-Checker
PHP cryptocurrency controller class.

### Usage:
include cryptocurrency-checker.php
```php
/*
 * @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
 * [CRYPTOCURRENCY CHECKER]
 * @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
*/
include('cryptocurrency-checker.php');
```
Initalizion
```php
$cc = new cryptoChecker;
```
Find out the current or cryptocurrency name
```php
echo $cc->check("CRYPTOCURRENCY_ADDRESS");
```
Supported Cryptocurrency List:
- BITCOIN-BTC
- BITCOIN_CASH-BCH
- BINANCE_COIN-BNB
- CARDANO-ADA
- DOGECOIN-DOGE
- ETHEREUM-ETH
- LITECOIN-LTC
- MONERO-XMR
- POLKADOT-DOT
- RIPPLE-XRP
- SOLANA-SOL
- STELLAR-XLM
- TETHER-USDT
- TRON-TRX
- ZCASH-ZEC
