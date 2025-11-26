<?php

namespace SdV\Ibp\Resources;

class Folder extends Resource
{
    use HasDates;

    public string $id;

    public string $name;

    public ?string $color;

    public ?int $filesCount;

    // Relations
    public string $applicationId;

    public string $organizationId;
}
