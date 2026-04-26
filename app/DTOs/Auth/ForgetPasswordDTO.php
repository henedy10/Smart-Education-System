<?php

namespace App\DTOs\Auth;

class ForgetPasswordDTO
{
    public function __construct(
        public readonly string $email,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            email: $request->input('email')
        );
    }
}
