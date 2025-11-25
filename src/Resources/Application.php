<?php

namespace SdV\Ibp\Resources;

class Application extends Resource
{
    use HasDates;

    public string $id;

    public string $name;

    public string $description;
}
