<?php

use Illuminate\Support\Facades\Cache;

it('can connect to redis and store data', function () {
    $testKey = 'test_key';
    $testValue = 'test_value';

    Cache::put($testKey, $testValue, 10); // No need to specify 'redis' explicitly

    expect(Cache::get($testKey))->toBe($testValue);

    Cache::forget($testKey); // Clean up
});
