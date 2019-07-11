<?php


namespace Pixidos\QRPayment\Values;


use Pixidos\QRPayment\Exceptions\InvalidValueException;
use function Pixidos\QRPayment\removeIlegalCharacters;

/**
 * Class ReceiveName
 * @package Pixidos\QRPayment\Values
 * @author Ondra Votava <ondra@votava.it>
 */
class ReceiveName implements ValueInterface
{
    /**
     * @var string
     */
    private $name;
    
    /**
     * ReceiveName constructor.
     *
     * @param string $name
     *
     * @throws InvalidValueException
     */
    public function __construct(string $name)
    {
        $this->name = $this->santize($name);
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getPrefix() . ':' . $this->name . '*';
    }
    
    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return 'RN';
    }
    
    
    /**
     * @param string $name
     *
     * @return string
     * @throws InvalidValueException
     */
    private function santize(string $name): string
    {
        $name = removeIlegalCharacters($name);
        if (\strlen($name) > 35) {
            throw new InvalidValueException('Receive name can be only max 35 chars long');
        }
        
        return strtoupper($name);
    }
}
