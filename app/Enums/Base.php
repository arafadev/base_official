<?php

namespace App\Enums;

use BadMethodCallException;
use Exception;
use ReflectionClass;

/**
 * Class Base
 * @package App\Enums
 */
abstract class Base
{
    public ReflectionClass $reflection;
    private mixed          $constants;

    public function __construct()
    {
        try {
            $this->reflection = new ReflectionClass(static::class);
            $this->constants  = $this->reflection->getConstants();
        } catch (Exception $e) {
            report($e);
        }
    }

    public function __call(string $name, array $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }

        throw new BadMethodCallException("Method $name does not exist in Class " . get_class($this));
    }

    public static function __callStatic(string $name, array $arguments)
    {
        $superClass = get_called_class();
        $childClass = new static();

        if (method_exists($superClass, $name)) {
            return call_user_func_array([$childClass, $name], $arguments);

        }

        throw new BadMethodCallException("Static method $name does not exist in Class $superClass");
    }

    /**
     * returns a string of constants integer values.
     *
     * @return string
     */
    protected function all(): string
    {
        return implode(',', array_values($this->constants));
    }

    /**
     * returns the array representation of all constants
     *
     * @return array
     */
    protected function toArray(): array
    {
        return $this->constants;
    }

    /**
     * returns the string representation from an integer.
     *
     * @param int|string|null $constValue
     * @return string|null
     */
    protected function nameFor(int|string|null $constValue): ?string
    {
        $flippedConstantsArray = array_flip($this->constants);

        if (isset($flippedConstantsArray[$constValue])) {
            $removeUnderScores = str_replace('_', ' ', $flippedConstantsArray[$constValue]);
            return __(ucfirst(strtolower($removeUnderScores)));
        }

        return null;
    }

    /**
     * Convert constants to array of objects when used by controllers
     * e.g. [{id: 1, name: 'new'}, ...]
     *
     * @return array
     */
    protected function forApi(): array
    {
        $newForm = [];

        foreach ($this->constants as $key => $val) {
            $newForm[] = ['id' => $val, 'name' => __(strtolower($key))];
        }

        return $newForm;
    }

    /**
     * Return constants to array of objects when used by controllers with title
     * e.g. [{id: 1, name: 'new'}, ...]
     *
     * @param string $file
     * @param string $prefix
     * @return array
     */
    protected function withTitle(string $file = 'enums', string $prefix = ''): array
    {
        return $this->mapper($this->constants, function ($a, $b) use ($file, $prefix) {
            return [
                'id'    => $b,
                'name'  => strtolower($a),
                'title' => __($file . ".$prefix" . strtolower($a))
            ];
        });
    }

    protected function mapper($arr, $callback): array
    {
        return array_map($callback, array_keys($arr), $arr);
    }

    /**
     * Convert constants to array of objects when used by controllers
     * e.g. [{id: 1, name: 'new'}, ...]
     *
     * @param int|string|null $constValue
     * @return string
     */
    protected function slug(int|string|null $constValue): string
    {
        $result = array_flip($this->constants);
        $result = $result[$constValue] ?? "";

        return strtolower($result);
    }

    protected function allKeys(): string
    {
        return strtolower(implode(',', array_keys($this->constants)));
    }

    protected function allKeysArray(): array
    {
        return array_keys(array_change_key_case($this->constants, CASE_LOWER));
    }

    protected function randomValue(): int|string
    {
        $result = $this->constants;

        return $result[array_rand($result)];
    }

    /**
     * Convert constants to array of objects when used by controllers
     * e.g. [{id: 1, name: 'new', title: 'جديد'}, ...]
     *
     * @param int|string|null $constValue , string $file = 'enums', string $prefix = ''
     * @param string $file
     * @param string $prefix
     * @return array
     */
    protected function toResource(int|string|null $constValue, string $file = 'enums', string $prefix = ''): array
    {
        $result = array_flip($this->constants);
        $result = $result[$constValue] ?? "";

        return [
            'id'    => $constValue,
            'name'  => strtolower($result),
            'title' => __($file . ".$prefix" . strtolower($result))
        ];
    }
}
