<?php

namespace App\DTOs\Auth;

class ResetPasswordDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public $token
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            email: $request->input('email'),
            password: $request->input('password'),
            token: $request->input('token')
        );
    }
}
