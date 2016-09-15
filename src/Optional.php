<?php

/**
 * PHP Optional
 *
 * @copyright Copyright (C) 2016 kazuhsat. All Rights Reserved.
 */

namespace Optional;

/**
 * Optional
 *
 * @author kazuhsat <kazuhsat555@gmail.com>
 */
final class Optional
{
    /**
     * value
     *
     * @var mixed
     */
    private $value = null;

    /**
     * constructor
     *
     * @param mixed $value
     * @return void
     */
    private function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * empty
     *
     * @return Optional
     */
    public static function empty() : Optional
    {
        return new self(null);
    }

    /**
     * equals
     *
     * @param mixed
     * @return boolean
     */
    public function equals($object) : bool
    {
        if (!($object instanceof Optional)) {
            return false;
        }

        return $this->value === $object->value;
    }

    /**
     * filter
     *
     * @param callable $predicate
     * @return Optional
     */
    // public function filter(callable $predicate) : Optional
    public function filter($predicate) : Optional
    {
        if (is_null($predicate)) {
            throw new NullPointerException();
        }

        if ($predicate($this->value) === true) {
            return $this;
        }

        return new self(null);
    }

    /**
     * flatMap
     *
     * @param callable $mapper
     * @return mixed
     */
    public function flatMap(callable $mapper)
    {
        /*
        if (is_null($this->value)) {
            return $this;
        }
        */

        return $mapper($this->value);
    }

    /**
     * get
     *
     * @return mixed
     * @throws NoSuchElementException
     */
    public function get()
    {
        if (is_null($this->value)) {
            throw new NoSuchElementException();
        }

        return $this->value;
    }

    /**
     * hashCode
     *
     * @return string
     */
    public function hashCode() : string # <- int
    {
        return spl_object_hash($this);
    }

    /**
     * ifPresent
     *
     * @param callable
     * @return void
     */
    public function ifPresent(callable $consumer)
    {
        if (!is_null($this->value)) {
            return $consumer($this->value);
        }
    }

    /**
     * isPresent
     *
     * @return boolean
     */
    public function isPresent() : bool
    {
        return !is_null($this->value);
    }

    /**
     * map
     *
     * @return mixed
     */
    public function map(callable $mapper)
    {
        if (is_null($this->value)) {
            return $this;
        }

        return $mapper($this);
    }

    /**
     * of
     *
     * @param mixed $value
     * @return Optional
     * @throws NullPointerException
     */
    public static function of($value) : Optional
    {
        if (is_null($value)) {
            throw new NullPointerException();
        }

        return new self($value);
    }

    /**
     * ofNullable
     *
     * @param mixed $value
     * @return Optional
     */
    public static function ofNullable($value)
    {
        return new self($value);
    }

    /**
     * orElse
     *
     * @param mixed
     * @return mixed
     */
    public function orElse($other)
    {
        return $this->value ?? $other;
    }

    /**
     * orElseGet
     *
     * @param callable $other
     * @return mixed
     */
    public function orElseGet(callable $other)
    {
        return $this->value ?? $other();
    }

    /**
     * orElseThrow
     *
     * @param Throwable $exception
     * @return mixed
     * @throws Throwable
     */
    public function orElseThrow(Throwable $exception)
    {
        if (is_null($this->value)) {
            throw $exception;
        } else {
            return $this->value;
        }
    }

    /**
     * toString
     *
     * @return string
     */
    public function toString()
    {
        return sprintf("Optional[%s]", $this->value);
    }
}
