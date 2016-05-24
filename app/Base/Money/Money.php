<?php

namespace Torg\Base\Money;

class Money
{
    const ROUND_HALF_UP = PHP_ROUND_HALF_UP;
    const ROUND_HALF_DOWN = PHP_ROUND_HALF_DOWN;
    const ROUND_HALF_EVEN = PHP_ROUND_HALF_EVEN;
    const ROUND_HALF_ODD = PHP_ROUND_HALF_ODD;
    const ROUND_UP = 5;
    const ROUND_DOWN = 6;
    const UNIT = 1000;

    /**
     * @var int
     */
    private $amount;

    /** @var Currency */
    private $currency;

    /**
     * Create a Money instance
     * @param  integer $amount    Amount, expressed in the smallest units of $currency (eg cents)
     * @param  Currency $currency
     * @throws InvalidArgumentException
     */
    public function __construct($amount, Currency $currency)
    {
        if (!is_int($amount)) {
            throw new InvalidArgumentException("The first parameter of Money must be an integer. It's the amount, expressed in the smallest units of currency (eg cents)");
        }
        $this->amount = $amount;
        $this->currency = $currency;
    }

    /**
     * Convenience factory method for a Money object
     * @example $fiveDollar = Money::USD(500);
     * @param string $method
     * @param array $arguments
     * @return Money
     */
    public static function __callStatic($method, $arguments)
    {
        return new Money($arguments[0], new Currency($method));
    }

    /**
     * @param Money $other
     * @return bool
     */
    public function isSameCurrency(Money $other)
    {
        return $this->currency->equals($other->currency);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function assertSameCurrency(Money $other)
    {
        if (!$this->isSameCurrency($other)) {
            throw new InvalidArgumentException('Different currencies');
        }
    }

    /**
     * @param Money $other
     * @return bool
     */
    public function equals(Money $other)
    {
        return
            $this->isSameCurrency($other)
            && $this->amount == $other->amount;
    }

    /**
     * @param Money $other
     * @return int
     */
    public function compare(Money $other)
    {
        $this->assertSameCurrency($other);
        if ($this->amount < $other->amount) {
            return -1;
        } elseif ($this->amount == $other->amount) {
            return 0;
        } else {
            return 1;
        }
    }

    /**
     * @param Money $other
     * @return bool
     */
    public function greaterThan(Money $other)
    {
        return 1 == $this->compare($other);
    }

    /**
     * @param Money $other
     * @return bool
     */
    public function greaterThanOrEqual(Money $other)
    {
        return 0 <= $this->compare($other);
    }

    /**
     * @param Money $other
     * @return bool
     */
    public function lessThan(Money $other)
    {
        return -1 == $this->compare($other);
    }

    /**
     * @param Money $other
     * @return bool
     */
    public function lessThanOrEqual(Money $other)
    {
        return 0 >= $this->compare($other);
    }

    /**
     * @deprecated Use getAmount() instead
     * @return int
     */
    public function getUnits()
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param Money $addend
     *@return Money
     */
    public function add(Money $addend)
    {
        $this->assertSameCurrency($addend);

        return new self($this->amount + $addend->amount, $this->currency);
    }

    /**
     * @param Money $subtrahend
     * @return Money
     */
    public function subtract(Money $subtrahend)
    {
        $this->assertSameCurrency($subtrahend);

        return new self($this->amount - $subtrahend->amount, $this->currency);
    }

    /**
     * @param int|float $operand
     * @throws InvalidArgumentException
     */
    private function assertOperand($operand)
    {
        if (!is_int($operand) && !is_float($operand)) {
            throw new InvalidArgumentException('Operand should be an integer or a float');
        }

    }

    /**
     * @throws InvalidArgumentException
     */
    private function assertRoundingMode($rounding_mode)
    {
        if (!in_array($rounding_mode, array(self::ROUND_HALF_DOWN, self::ROUND_HALF_EVEN, self::ROUND_HALF_ODD, self::ROUND_HALF_UP, self::ROUND_UP, self::ROUND_DOWN))) {
            throw new InvalidArgumentException(
                'Rounding mode should be Money::ROUND_HALF_DOWN | Money::ROUND_HALF_EVEN | Money::ROUND_HALF_ODD | Money::ROUND_HALF_UP | Money::ROUND_UP | Money::ROUND_DOWN'
            );
        }
    }

    /**
     * @param $multiplier
     * @param int $rounding_mode
     * @return Money
     */
    public function multiply($multiplier, $rounding_mode = self::ROUND_HALF_UP)
    {
        $this->assertOperand($multiplier);

        $product = $this->round($this->amount * $multiplier, $rounding_mode);

        return new Money($product, $this->currency);
    }

    /**
     * @param $divisor
     * @param int $rounding_mode
     * @return Money
     */
    public function divide($divisor, $rounding_mode = self::ROUND_HALF_UP)
    {
        if ($divisor === 0 || $divisor === 0.0){
            throw new InvalidArgumentException('Division by zero');
        }

        $this->assertOperand($divisor, true);

        $quotient = $this->round($this->amount / $divisor, $rounding_mode);

        return new Money($quotient, $this->currency);
    }

    /**
     * Allocate the money according to a list of ratio's
     * @param array $ratios List of ratio's
     * @return Money
     */
    public function allocate(array $ratios)
    {
        $remainder = $this->amount;
        $results = array();
        $total = array_sum($ratios);

        foreach ($ratios as $ratio) {
            $share = (int) floor($this->amount * $ratio / $total);
            $results[] = new Money($share, $this->currency);
            $remainder -= $share;
        }
        for ($i = 0; $remainder > 0; $i++) {
            $results[$i]->amount++;
            $remainder--;
        }

        return $results;
    }

    /**
     * @param int|float $amount
     * @param $rounding_mode
     * @return int
     */
    private function round($amount, $rounding_mode)
    {
        $this->assertRoundingMode($rounding_mode);

        if ($rounding_mode === self::ROUND_UP) {
            return (int) ceil($amount);
        }

        if ($rounding_mode === self::ROUND_DOWN) {
            return (int) floor($amount);
        }

        return (int) round($amount, 0, $rounding_mode);
    }

    /** @return bool */
    public function isZero()
    {
        return $this->amount === 0;
    }

    /** @return bool */
    public function isPositive()
    {
        return $this->amount > 0;
    }

    /** @return bool */
    public function isNegative()
    {
        return $this->amount < 0;
    }

    /**
     * @param $string
     * @throws \Money\InvalidArgumentException
     * @return int
     */
    public static function stringToUnits( $string )
    {
        $sign = "(?P<sign>[-\+])?";
        $digits = "(?P<digits>\d*)";
        $separator = "(?P<separator>[.,])?";
        $decimals = "(?P<decimal1>\d)?(?P<decimal2>\d)?";
        $pattern = "/^".$sign.$digits.$separator.$decimals."$/";

        // Remove any currency symbols before attempting to parse.
        $string = preg_replace('@\p{Sc}*@u', '', $string);

        if (!preg_match($pattern, trim($string), $matches)) {
            throw new InvalidArgumentException("The value could not be parsed as money");
        }

        $units = $matches['sign'] == "-" ? "-" : "";
        $units .= $matches['digits'];
        $units .= isset($matches['decimal1']) ? $matches['decimal1'] : "0";
        $units .= isset($matches['decimal2']) ? $matches['decimal2'] : "0";

        return (int) $units;
    }
}
