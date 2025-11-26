<?php

namespace SdV\Ibp\Resources;

#[\AllowDynamicProperties]
class Resource
{
    public array $attributes;

    /**
     * Create a new resource instance.
     *
     * @param  array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;

        $this->fill();
    }

    /**
     * Fill the resource with the array of attributes.
     *
     * @return void
     */
    private function fill(): void
    {
        foreach ($this->attributes as $key => $value) {
            $key = $this->camelCase($key);
            $this->{$key} = $value;
        }
    }

    /**
     * Convert the key name to camel case.
     *
     * @param $key
     */
    private function camelCase(string $key): string
    {
        $parts = explode('_', $key);
        foreach ($parts as $i => $part) {
            if ($i !== 0) {
                $parts[$i] = ucfirst($part);
            }
        }
        return str_replace(' ', '', implode(' ', $parts));
    }
}
