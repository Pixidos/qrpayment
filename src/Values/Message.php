<?php


namespace Pixidos\QRPayment\Values;


use Pixidos\QRPayment\Exceptions\InvalidValueException;
use RuntimeException;
use function Pixidos\QRPayment\removeIlegalCharacters;
use function strlen;

/**
 * Class Message
 * @package Pixidos\QRPayment\Values
 * @author Ondra Votava <ondra@votava.it>
 */
class Message implements ValueInterface
{
    /**
     * @var string
     */
    private $message;
    
    /**
     * Message constructor.
     *
     * @param string $message max 60 chars
     *
     * @throws InvalidValueException
     * @throws RuntimeException
     */
    public function __construct(string $message)
    {
        $message = removeIlegalCharacters($message);
        if (strlen($message) > 60) {
            throw new InvalidValueException('Message is too long. Max is 60 chars');
        }
        
        $this->message = $message;
    }
    
    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
    
    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return 'MSG';
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getPrefix() . ':' . $this->message . '*';
    }
}
