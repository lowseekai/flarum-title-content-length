<?php

/*
 * This file is part of litalino/flarum-title-content-length.
 *
 * Copyright (c) 2023 Litalino.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Litalino\TitleContentLength;

use Flarum\Api\Resource\DiscussionResource;
use Flarum\Api\Resource\PostResource;
use Flarum\Extend;
use Flarum\Settings\SettingsRepositoryInterface;

$replaceLengthRules = static function ($field, string $settingPrefix, int $defaultMin, int $defaultMax) {
    $settings = resolve(SettingsRepositoryInterface::class);

    if (! $settings->get($settingPrefix.'.limit', true)) {
        return $field;
    }

    $minimum = (int) $settings->get($settingPrefix.'.min', $defaultMin);
    $maximum = (int) $settings->get($settingPrefix.'.max', $defaultMax);

    $minimum = $minimum > 0 ? $minimum : $defaultMin;
    $maximum = $maximum > 0 ? $maximum : $defaultMax;

    // Rebuild the existing rule list so core min/max values are replaced
    // while required and other conditional rules remain intact.
    $rules = $field->getRules();
    $field->rules([], true);

    $hasMinimum = false;
    $hasMaximum = false;

    foreach ($rules as $rule) {
        $value = $rule['rule'];

        if (is_string($value) && str_starts_with($value, 'min:')) {
            $value = 'min:'.$minimum;
            $hasMinimum = true;
        } elseif (is_string($value) && str_starts_with($value, 'max:')) {
            $value = 'max:'.$maximum;
            $hasMaximum = true;
        }

        $field->rule($value, $rule['condition']);
    }

    if (! $hasMinimum) {
        $field->minLength($minimum);
    }

    if (! $hasMaximum) {
        $field->maxLength($maximum);
    }

    return $field;
};

return [
    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    new Extend\Locales(__DIR__.'/locale'),

    (new Extend\Settings())
        ->default('litalino-title-length.limit', true)
        ->default('litalino-title-length.min', 15)
        ->default('litalino-title-length.max', 180)
        ->default('litalino-content-length.limit', true)
        ->default('litalino-content-length.min', 30)
        ->default('litalino-content-length.max', 65000),

    (new Extend\ApiResource(DiscussionResource::class))
        ->field('title', function ($field) use ($replaceLengthRules) {
            return $replaceLengthRules($field, 'litalino-title-length', 3, 80)
                ->validationAttributes(['title' => '标题']);
        })
        ->field('content', function ($field) use ($replaceLengthRules) {
            return $replaceLengthRules($field, 'litalino-content-length', 0, 63000)
                ->validationAttributes(['content' => '内容']);
        }),

    (new Extend\ApiResource(PostResource::class))
        ->field('content', function ($field) use ($replaceLengthRules) {
            return $replaceLengthRules($field, 'litalino-content-length', 0, 63000)
                ->validationAttributes(['content' => '内容']);
        }),
];
