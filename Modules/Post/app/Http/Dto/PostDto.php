<?php

namespace Modules\Post\Http\Dto;

class PostDto
{

    public string $title;
    public string $description;
    public string $user_id;
    public function __construct(string $title, string $description, string $user_id)
    {
        $this->title = $title;
        $this->description = $description;
        $this->user_id = $user_id;
    }
}
