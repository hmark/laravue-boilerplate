<?php

namespace App\Dtos\I18n;

use App\Enums\Language;

final class GetLanguageDto
{
    public function __construct(
        public Language $language,
    ){}
}
