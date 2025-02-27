<?php

namespace App\Traits;

use App\Models\VerificationCode;
use Nette\Utils\Random;

trait HasGenerateCode {
    private function generateCode(int $length = 5): string {
        return Random::generate($length, '0-9a-z');
    }

    public function generateVerificationCode(
        object $user,

    ) : VerificationCode {
        $code = $this->generateCode();
        while(
            VerificationCode::where('code', $code)->first() ||
            strlen($code) !== 5
        ) {
            return VerificationCode::create([
                'user_id' => $user->id,
                'expired_at' => now()->addMinutes(10),
                'code' => $this->generateCode(),
            ]);
        }
    }
}