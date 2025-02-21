<?php

namespace Modules\User\Http\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Attributes\Validation\Min;

class RegisterData extends Data
{
    public function __construct(
        #[Required, Email]
        public string $email,

        #[Required, Min(8)]
        public string $password,

        #[Required]
        public string $name
    ) {}
}
