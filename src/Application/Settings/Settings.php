<?php

declare(strict_types=1);

namespace App\Application\Settings;

use Webmozart\Assert\Assert;

class Settings implements SettingsInterface
{
    /**
     * @var array<string, mixed>
     */
    private array $settings;

    /**
     * Settings constructor.
     * @param array<string, mixed> $settings
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key = '')
    {
        return ($key === '') ? $this->settings : $this->settings[$key];
    }
}
