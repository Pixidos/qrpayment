<?php declare(strict_types=1);


namespace Pixidos\QRPayment\Values;


use Pixidos\QRPayment\Exceptions\InvalidIbanException;

/**
 * Class Iban
 * @package Pixidos\QRPayment\Values
 * @author Ondra Votava <ondra@votava.it>
 */
class Iban
{
    /**
     * @var array
     */
    private static $ibanLenghts = [
        'AL' => 28,
        'AD' => 24,
        'AT' => 20,
        'AZ' => 28,
        'BH' => 22,
        'BE' => 16,
        'BA' => 20,
        'BR' => 29,
        'BG' => 22,
        'CR' => 21,
        'HR' => 21,
        'CY' => 28,
        'CZ' => 24,
        'DK' => 18,
        'DO' => 28,
        'EE' => 20,
        'FO' => 18,
        'FI' => 18,
        'FR' => 27,
        'GE' => 22,
        'DE' => 22,
        'GI' => 23,
        'GR' => 27,
        'GL' => 18,
        'GT' => 28,
        'HU' => 28,
        'IS' => 26,
        'IE' => 22,
        'IL' => 23,
        'IT' => 27,
        'JO' => 30,
        'KZ' => 20,
        'KW' => 30,
        'LV' => 21,
        'LB' => 28,
        'LI' => 21,
        'LT' => 20,
        'LU' => 20,
        'MK' => 19,
        'MT' => 31,
        'MR' => 27,
        'MU' => 30,
        'MC' => 27,
        'MD' => 24,
        'ME' => 22,
        'NL' => 18,
        'NO' => 15,
        'PK' => 24,
        'PS' => 29,
        'PL' => 28,
        'PT' => 25,
        'QA' => 29,
        'RO' => 24,
        'SM' => 27,
        'SA' => 24,
        'RS' => 22,
        'SK' => 24,
        'SI' => 19,
        'ES' => 24,
        'SE' => 24,
        'CH' => 21,
        'TN' => 24,
        'TR' => 26,
        'AE' => 23,
        'GB' => 22,
        'VG' => 24,
    ];
    /**
     * RegExp pattern for Iban
     */
    private static $ibanPattern = '/(?P<countryCode>[A-Z]{2})(?P<check>\d{2})(?P<bban>[A-Z0-9]{11,26})$/';
    
    /**
     * Country code using ISO 3166-1 alpha-2 - two letters
     * @var string $countryCode
     */
    private $countryCode;
    /**
     * Check digits - two digits
     * @var string $check
     */
    private $check;
    /**
     * Basic Bank Account Number (BBAN) - up to 30 alphanumeric characters that
     * are country-specific.
     * @var string
     */
    private $bban;
    /**
     * @var string
     */
    private $iban;
    
    /**
     * Iban constructor.
     *
     * @param string $iban
     *
     * @throws InvalidIbanException
     */
    public function __construct(string $iban)
    {
        $this->iban = strtoupper($this->sanitize($iban));
        $this->parseString($iban);
        $this->validate();
    }
    
    /**
     * @param array $ibanLenghts
     */
    public static function setIbanLenghts(array $ibanLenghts): void
    {
        static::$ibanLenghts = $ibanLenghts;
        $min = min(static::$ibanLenghts) - 4;
        $max = max(static::$ibanLenghts) - 4;
        static::$ibanPattern = '/(?P<countryCode>[A-Z]{2})(?P<check>\d{2})(?P<bban>[A-Z0-9]{' . $min . ',' . $max . '})$/';
    }
    
    /**
     * @param string $separator supported separators are white spaces (regex \s) and hyphen (-) all other separators
     *                           will not be able to be converted back into objects, a combination may be used.
     * @param int    $size the separator group size to use, this will chunk
     * @param bool   $prefix when true `Iban ` will be prefixed
     *
     * @return string
     */
    public function toFormattedString($separator = '', $size = 0, $prefix = false): string
    {
        $accountNumber = $this->countryCode . $this->check . $this->bban;
        if ($size > 0) {
            $accountNumber = implode($separator, (array)str_split($this->countryCode . $this->check . $this->bban, $size));
        }
        
        if ($prefix) {
            $accountNumber = 'IBAN ' . $accountNumber;
        }
        
        return $accountNumber;
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toFormattedString();
    }
    
    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }
    
    /**
     * @param string $iban
     *
     * @throws InvalidIbanException
     */
    private function parseString(string $iban): void
    {
        
        if (!preg_match(static::$ibanPattern, $this->iban, $matches)) {
            throw new InvalidIbanException("Iban: '{$iban}' has invalid format");
        }
        $this->countryCode = $matches['countryCode'];
        $this->check = $matches['check'];
        $this->bban = $matches['bban'];
    }
    
    /**
     * @param string $iban
     *
     * @return string
     * @throws InvalidIbanException
     */
    private function sanitize(string $iban): string
    {
        $original = $iban;
        # Uppercase and trim spaces from left
        $iban = strtoupper(ltrim($iban));
        # Remove IIBAN or IBAN from start of string, if present
        $iban = preg_replace('/^I?IBAN/', '', $iban);
        # Remove all non basic roman letter / digit characters
        $iban = preg_replace('/[^a-zA-Z0-9]/', '', (string)$iban);
        if (null === $iban) {
            throw new InvalidIbanException("Iban: '{$original}' is invalid");
        }
        
        return $iban;
    }
    
    /**
     * @throws InvalidIbanException
     */
    private function validate(): void
    {
        if (!array_key_exists($this->countryCode, static::$ibanLenghts)) {
            throw new InvalidIbanException(
                sprintf("Country '%s' for Iban is not (yet) supported: '%s'", $this->countryCode, implode(', ', array_keys(self::$ibanLenghts)))
            );
        }
        
        if (strlen($this->iban) !== static::$ibanLenghts[$this->countryCode]) {
            throw new InvalidIbanException("Iban not long enough: '{$this->iban}'");
        }
        
        $numeric = $this->toNumeric();
        $result = 98 - (int)bcmod($numeric, (string)97);
        if ($result !== (int)$this->check) {
            throw new InvalidIbanException("Iban: '{$this->iban}' is invalid");
        }
    }
    
    /**
     * @return string
     */
    private function toNumeric(): string
    {
        // To numeric representation
        $search = range('A', 'Z');
        $replace = [];
        foreach (range(10, 35) as $tmp) {
            $replace[] = (string)$tmp;
        }
        
        return str_replace($search, $replace, $this->bban . $this->countryCode . '00');
    }
    
}
