<?php

namespace App\Forms;

use App\Enums\SocialIcon\PlatformEnum;
use App\Models\SocialIcon;
use Illuminate\Validation\Rule;
use Livewire\Form;

class SocialIconForm extends Form
{
    public ?SocialIcon $socialIcon = null;

    public ?string $url = '';

    public ?PlatformEnum $platform = null;

    public bool $is_active = true;

    public function rules(): array
    {
        return [
            'url' => ['required', 'string', 'max:255'],
            'platform' => [
                'required',
                Rule::unique('social_icons', 'platform')
                    ->where('user_id', auth()->id())
                    ->ignore($this->socialIcon?->id),
            ],
            'is_active' => ['boolean'],
        ];
    }

    public function set(SocialIcon $socialIcon): void
    {
        $this->socialIcon = $socialIcon;
        $this->url = $socialIcon->url;
        $this->platform = $socialIcon->platform;
        $this->is_active = $socialIcon->is_active;
    }

    public function save(): void
    {
        $validated = $this->validate();

        if ($this->socialIcon) {
            $this->socialIcon->update($validated);
        } else {
            auth()->user()->socialIcons()->create($this->all());
        }
    }
}
