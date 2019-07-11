<?php


namespace Pixidos\QRPayment\Values;


use Pixidos\QRPayment\Exceptions\InvalidValueException;
use function Pixidos\QRPayment\removeIlegalCharacters;

/**
 * Class Message
 * @package Pixidos\QRPayment\Values
 * @author Ondra Votava <ondra@votava.it>
 */
class Message
{
    private $message;
    
    /**
     * Message constructor.
     *
     * @param string $message max 60 chars
     *
     * @throws InvalidValueException
     */
    public function __construct(string $message)
    {
        $message = removeIlegalCharacters($message);
        if (\strlen($message) > 60) {
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
    
    public function __toString()
    {
        return 'MSG:' . $this->message . '*';
    }
}
