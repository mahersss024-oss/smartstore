<?php

namespace App\Forms;

use App\Models\Product;
use Exception;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductForm extends Form
{
    public ?Product $product = null;

    public ?string $name;

    public ?string $description;

    public ?string $affiliate_url;

    public ?TemporaryUploadedFile $media = null;

    public ?Media $media_preview = null;

    public bool $is_active = true;

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'affiliate_url' => ['required', 'url'],
            'is_active' => ['nullable'],
            'media' => ['nullable', 'image', 'max:10240'], // 10 MB,
        ];
    }

    public function set(Product $product): void
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->affiliate_url = $product->affiliate_url;
        $this->is_active = $product->is_active;
        $this->media_preview = $product->getMedia()->first();
    }

    public function deleteMedia(int $mediaId): void
    {
        $media = $this->product?->getMedia()->firstWhere('id', $mediaId);

        if ($media) {
            $media->delete();
            $this->media_preview = null;
        }
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     * @throws Exception
     */
    public function save(): void
    {
        $validated = $this->validate();

        if ($this->product) {
            $this->product->update($validated);
        } else {
            if (! auth()->user()->subscribed() && auth()->user()->products()->count() > 30) {
                throw new Exception('You can only add maximum of 30 products. Subscribe to a premium plan to add more.');
            }

            $this->product = auth()->user()->products()->create($validated);
        }

        if ($this->media) {
            $this->product->clearMediaCollection();
            $this->product->addMedia($this->media)->toMediaCollection();
        }
    }
}
