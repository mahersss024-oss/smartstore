<?php

namespace App\Livewire\Products;

use App\Forms\ProductForm;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductsIndex extends Component
{
    use WithFileUploads;
    use WithPagination;

    public ProductForm $form;

    public $showProductModal = false;

    public function create(): void
    {
        $this->form->reset();

        $this->showProductModal = true;
    }

    public function edit(int $productId): void
    {
        $product = Product::query()
            ->where('user_id', auth()->id())
            ->findOrFail($productId);

        $this->form->set($product);

        $this->showProductModal = true;
    }

    public function save(): void
    {
        try {
            $this->form->save();
        } catch (\Exception $exception) {
            if (! $exception instanceof ValidationException) {
                $this->dispatch('notify', message: $exception->getMessage(), type: 'error');

                return;
            }

            throw $exception;
        }

        $this->form->reset();

        $this->showProductModal = false;
    }

    public function delete(int $productId): void
    {
        $product = Product::query()->find($productId);

        if ($product && $product->user_id === auth()->id()) {
            $product->delete();
        }
    }

    public function deleteMedia(int $mediaId): void
    {
        $this->form->deleteMedia($mediaId);
    }

    public function render(): View
    {
        $products = Product::query()
            ->where('user_id', auth()->id())
            ->latest('created_at')
            ->paginate(10);

        return view('livewire.products.products-index', [
            'products' => $products,
        ]);
    }
}
