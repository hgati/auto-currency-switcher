<?php
namespace Hgati\AutoCurrencySwitcher\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	/**
	 * @var ScopeConfigInterface
	 */
	protected $scopeConfig;

	const XML_PATH_AUTOCURRENCY_ENABLED = 'hgati_autocurrencyswitcher/general/enabled';

	public function __construct(
		ScopeConfigInterface $scopeConfig
	)
	{
		$this->scopeConfig = $scopeConfig;
	}
	
	/**
	 * Check if the module is enabled
	 * 
	 * @return boolean 0 or 1
	 */ 
	public function isEnabled()
    {
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;	
        return $this->scopeConfig->getValue(self::XML_PATH_AUTOCURRENCY_ENABLED, $storeScope);
    }
        
	/**
	 * Get Currency code by Country code
	 * 
	 * @return string
	 */ 
	public function getCurrencyByCountry($countryCode)
	{
		$map = array( '' => '',
		"EU" => "EUR", "AD" => "EUR", "AE" => "AED", "AF" => "AFN", "AG" => "XCD", "AI" => "XCD", 
		"AL" => "ALL", "AM" => "AMD", "CW" => "ANG", "AO" => "AOA", "AQ" => "AQD", "AR" => "ARS", "AS" => "EUR", 
		"AT" => "EUR", "AU" => "AUD", "AW" => "AWG", "AZ" => "AZN", "BA" => "BAM", "BB" => "BBD", 
		"BD" => "BDT", "BE" => "EUR", "BF" => "XOF", "BG" => "BGL", "BH" => "BHD", "BI" => "BIF", 
		"BJ" => "XOF", "BM" => "BMD", "BN" => "BND", "BO" => "BOB", "BR" => "BRL", "BS" => "BSD", 
		"BT" => "BTN", "BV" => "NOK", "BW" => "BWP", "BY" => "BYR", "BZ" => "BZD", "CA" => "CAD", 
		"CC" => "AUD", "CD" => "CDF", "CF" => "XAF", "CG" => "XAF", "CH" => "CHF", "CI" => "XOF", 
		"CK" => "NZD", "CL" => "CLP", "CM" => "XAF", "CN" => "CNY", "CO" => "COP", "CR" => "CRC", 
		"CU" => "CUP", "CV" => "CVE", "CX" => "AUD", "CY" => "EUR", "CZ" => "CZK", "DE" => "EUR", 
		"DJ" => "DJF", "DK" => "DKK", "DM" => "XCD", "DO" => "DOP", "DZ" => "DZD", "EC" => "ECS", 
		"EE" => "EEK", "EG" => "EGP", "EH" => "MAD", "ER" => "ETB", "ES" => "EUR", "ET" => "ETB", 
		"FI" => "EUR", "FJ" => "FJD", "FK" => "FKP", "FM" => "USD", "FO" => "DKK", "FR" => "EUR", "SX" => "ANG",
		"GA" => "XAF", "GB" => "GBP", "GD" => "XCD", "GE" => "GEL", "GF" => "EUR", "GH" => "GHS", 
		"GI" => "GIP", "GL" => "DKK", "GM" => "GMD", "GN" => "GNF", "GP" => "EUR", "GQ" => "XAF", 
		"GR" => "EUR", "GS" => "GBP", "GT" => "GTQ", "GU" => "USD", "GW" => "XOF", "GY" => "GYD", 
		"HK" => "HKD", "HM" => "AUD", "HN" => "HNL", "HR" => "HRK", "HT" => "HTG", "HU" => "HUF", 
		"ID" => "IDR", "IE" => "EUR", "IL" => "ILS", "IN" => "INR", "IO" => "USD", "IQ" => "IQD", 
		"IR" => "IRR", "IS" => "ISK", "IT" => "EUR", "JM" => "JMD", "JO" => "JOD", "JP" => "JPY", 
		"KE" => "KES", "KG" => "KGS", "KH" => "KHR", "KI" => "AUD", "KM" => "KMF", "KN" => "XCD", 
		"KP" => "KPW", "KR" => "KRW", "KW" => "KWD", "KY" => "KYD", "KZ" => "KZT", "LA" => "LAK", 
		"LB" => "LBP", "LC" => "XCD", "LI" => "CHF", "LK" => "LKR", "LR" => "LRD", "LS" => "LSL", 
		"LT" => "LTL", "LU" => "EUR", "LV" => "LVL", "LY" => "LYD", "MA" => "MAD", "MC" => "EUR", 
		"MD" => "MDL", "MG" => "MGF", "MH" => "USD", "MK" => "MKD", "ML" => "XOF", "MM" => "MMK", 
		"MN" => "MNT", "MO" => "MOP", "MP" => "USD", "MQ" => "EUR", "MR" => "MRO", "MS" => "XCD", 
		"MT" => "EUR", "MU" => "MUR", "MV" => "MVR", "MW" => "MWK", "MX" => "MXN", "MY" => "MYR", 
		"MZ" => "MZN", "NA" => "NAD", "NC" => "XPF", "NE" => "XOF", "NF" => "AUD", "NG" => "NGN", 
		"NI" => "NIO", "NL" => "EUR", "NO" => "NOK", "NP" => "NPR", "NR" => "AUD", "NU" => "NZD", 
		"NZ" => "NZD", "OM" => "OMR", "PA" => "PAB", "PE" => "PEN", "PF" => "XPF", "PG" => "PGK", 
		"PH" => "PHP", "PK" => "PKR", "PL" => "PLN", "PM" => "EUR", "PN" => "NZD", "PR" => "USD", "PS" => "ILS", "PT" => "EUR", 
		"PW" => "USD", "PY" => "PYG", "QA" => "QAR", "RE" => "EUR", "RO" => "RON", "RU" => "RUB", 
		"RW" => "RWF", "SA" => "SAR", "SB" => "SBD", "SC" => "SCR", "SD" => "SDD", "SE" => "SEK", 
		"SG" => "SGD", "SH" => "SHP", "SI" => "EUR", "SJ" => "NOK", "SK" => "SKK", "SL" => "SLL", 
		"SM" => "EUR", "SN" => "XOF", "SO" => "SOS", "SR" => "SRG", "ST" => "STD", "SV" => "SVC", 
		"SY" => "SYP", "SZ" => "SZL", "TC" => "USD", "TD" => "XAF", "TF" => "EUR", "TG" => "XOF", 
		"TH" => "THB", "TJ" => "TJS", "TK" => "NZD", "TM" => "TMM", "TN" => "TND", "TO" => "TOP", "TL" => "USD",
		"TR" => "TRY", "TT" => "TTD", "TV" => "AUD", "TW" => "TWD", "TZ" => "TZS", "UA" => "UAH", 
		"UG" => "UGX", "UM" => "USD", "US" => "USD", "UY" => "UYU", "UZ" => "UZS", "VA" => "EUR", 
		"VC" => "XCD", "VE" => "VEF", "VG" => "USD", "VI" => "USD", "VN" => "VND", "VU" => "VUV",
		"WF" => "XPF", "WS" => "EUR", "YE" => "YER", "YT" => "EUR", "RS" => "RSD", 
		"ZA" => "ZAR", "ZM" => "ZMK", "ME" => "EUR", "ZW" => "ZWD",
		"AX" => "EUR", "GG" => "GBP", "IM" => "GBP", 
		"JE" => "GBP", "BL" => "EUR", "MF" => "EUR", "BQ" => "USD", "SS" => "SSP"
		);
		
		return $map[$countryCode];
	}
}