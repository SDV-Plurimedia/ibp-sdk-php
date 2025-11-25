<?php

namespace SdV\Ibp\Resources;

class Error extends Resource
{
    public int $status;

    public string $title;

    public string $messages;
}
