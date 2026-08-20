<?php

namespace App\Livewire;

use App\Enums\SocialIcon\PlatformEnum;
use App\Forms\SocialIconForm;
use App\Models\SocialIcon;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class SocialIconsIndex extends Component
{
    use WithPagination;

    public SocialIconForm $form;

    public $showSocialIconModal = false;

    public $availablePlatforms = [];

    public $platformExample = 'https://example.com';

    public function mount(): void
    {
        $this->getUserAvailablePlatforms();
    }

    private function getUserAvailablePlatforms(): void
    {
        $userPlatforms = auth()->user()->socialIcons()->pluck('platform')->toArray();

        $this->availablePlatforms = collect(PlatformEnum::cases())
            ->reject(fn ($platform) => in_array($platform, $userPlatforms))
            ->all();
    }

    public function create(): void
    {
        $this->form->reset();
        $this->getUserAvailablePlatforms();
        $this->showSocialIconModal = true;
    }

    public function edit(int $socialIconId): void
    {
        $socialIcon = SocialIcon::query()
            ->where('user_id', auth()->id())
            ->findOrFail($socialIconId);

        $this->form->set($socialIcon);
        $this->availablePlatforms = [$socialIcon->platform];
        $this->platformExample = $socialIcon->platform->example();
        $this->showSocialIconModal = true;
    }

    public function save(): void
    {
        $this->form->save();
        $this->form->reset();
        $this->showSocialIconModal = false;
    }

    public function delete(int $socialIconId): void
    {
        $socialIcon = SocialIcon::query()->find($socialIconId);

        if ($socialIcon && $socialIcon->user_id === auth()->id()) {
            $socialIcon->delete();
        }
    }

    public function toggleActive(int $socialIconId): void
    {
        $socialIcon = SocialIcon::query()
            ->where('user_id', auth()->id())
            ->findOrFail($socialIconId);

        $socialIcon->update(['is_active' => ! $socialIcon->is_active]);
    }

    public function updatedFormPlatform($value): void
    {
        if ($value) {
            $this->platformExample = $value->example();
        } else {
            $this->platformExample = '';
        }
    }

    public function render(): View
    {
        $socialIcons = auth()->user()->socialIcons()->get();

        return view('livewire.social-icons-index', [
            'socialIcons' => $socialIcons,
            'platformExample' => $this->platformExample,
        ]);
    }
}
