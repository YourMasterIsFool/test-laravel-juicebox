<?php

namespace Modules\Post\Http\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Attributes\Validation\Min;

class PostData extends Data
{
    public function __construct(
        #[Required]
        public string $title,
        #[Required]
        public string $description,

    ) {}

    public static function messages(): array
    {
        return [
            'title.required' => 'Title tidak boleh kosong',
            'description.required' => 'Description tidak boleh kosong'
        ];
    }
}
