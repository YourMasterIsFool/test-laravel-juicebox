<?php

namespace Modules\Post\Http\Dto;

class UpdatePostDto
{

    public string $title;
    public string $description;
    public function __construct(string $title, string $description)
    {
        $this->title = $title;
        $this->description = $description;
    }
}
