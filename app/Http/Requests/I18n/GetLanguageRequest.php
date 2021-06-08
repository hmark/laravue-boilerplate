<?php

namespace App\Http\Requests\I18n;

use App\Dtos\I18n\GetLanguageDto;
use App\Enums\Language;
use App\Http\Requests\Request;

class GetLanguageRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'lang' => 'required|enum_key:' . Language::class,
        ];
    }

    public function getDto(): GetLanguageDto
    {
        $data = $this->validated();

        return new GetLanguageDto(
            Language::fromValue($data['lang']),
        );
    }
}
