<?php

namespace App\Livewire\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProfileSettings extends Component
{
    use WithFileUploads;

    public $name;

    #[Validate]
    public $username;

    public $description;

    public $logo;

    public ?Media $logo_preview = null;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:30', 'regex:/^[a-zA-Z0-9_]+$/', 'unique:users,username,' . Auth::id()],
            'description' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:3072'], // 3MB max
        ];
    }

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->display_name;
        $this->username = $user->username;
        $this->description = $user->bio;
        $this->logo_preview = $user->getFirstMedia('default');
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function save()
    {
        $this->validate();

        $user = Auth::user();

        $user->display_name = $this->name;
        $user->username = $this->username;
        $user->bio = $this->description;
        $user->save();

        if ($this->logo) {
            $user->clearMediaCollection('default');
            $user->addMedia($this->logo)->toMediaCollection('default');
            $this->logo_preview = $user->getFirstMedia('default');
            $this->logo = null;
        }

        session()->flash('message', 'Profile settings saved successfully!');
    }

    public function deleteLogo(): void
    {
        $user = Auth::user();
        $user->clearMediaCollection('default');
        $this->logo_preview = null;
        session()->flash('message', 'Logo deleted successfully!');
    }

    public function render()
    {
        return view('livewire.settings.profile-settings');
    }
}
