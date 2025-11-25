<?php

namespace SdV\Ibp\Resources;

class File extends Resource
{
    use HasDates;

    public string $id;

    public string $extension;

    public string $extensionOriginale;

    public string $fichierOriginal;

    public string $path;

    public string $ibpPath;

    public int $size;

    public string $md5sum;

    public string $mimeType;

    public ?array $extra;

    public array $methodes;

    public array $meta;

    public array $exif;

    // Relations
    public string $userId;

    public string $applicationId;

    public string $organizationId;
}
