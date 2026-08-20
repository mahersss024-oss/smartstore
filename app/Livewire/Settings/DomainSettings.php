<?php

namespace App\Livewire\Settings;

use App\Models\Domain;
use App\Services\DomainService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Pdp\CannotProcessHost;

class DomainSettings extends Component
{
    public ?Domain $domain = null;

    public $name = '';

    public $subDomain = null;

    public $registrableDomain = null;

    /**
     * @throws CannotProcessHost
     */
    public function mount(): void
    {
        $this->refreshDomain();
    }

    /**
     * @throws CannotProcessHost
     */
    private function refreshDomain(): void
    {
        $this->domain = Auth::user()->domain;
        $this->name = $this->domain?->name ?? '';
        if ($this->domain) {
            $pdpDomain = app(DomainService::class)->pdpResolvedDomain($this->domain);

            $this->subDomain = $pdpDomain->subDomain()->value();
            $this->registrableDomain = $pdpDomain->registrableDomain()->value();
        }

        $this->dispatch('domain-updated');
    }

    /**
     * @throws CannotProcessHost
     */
    public function save(): void
    {
        $this->validate([
            'name' => 'nullable|string|max:255|regex:/^([a-zA-Z0-9][a-zA-Z0-9-_]*\.)+[a-zA-Z0-9][a-zA-Z0-9-_]*$/',
        ], [
            'name.regex' => 'Please enter a valid domain without http:// or https://',
        ]);

        if (empty($this->name)) {
            if ($this->domain) {
                $this->domain->delete();
                $this->refreshDomain();
                session()->flash('message', 'Domain removed successfully!');
            }

            return;
        }

        if (! auth()->user()->subscribed()) {
            session()->flash('error', 'You need to subscribe plan to connect your domain.');

            return;
        }

        if ($this->domain) {
            $this->domain->update(['name' => $this->name]);
        } else {
            $this->domain = Domain::create([
                'user_id' => auth()->id(),
                'name' => $this->name,
            ]);
        }

        $this->refreshDomain();
        session()->flash('message', 'Domain settings saved successfully!');
    }

    public function verifyDomain(): void
    {
        if (! auth()->user()->subscribed()) {
            session()->flash('error', 'You need to subscribe plan to connect your domain.');

            return;
        }

        $domainService = new DomainService;

        try {
            $domainService->verifyDomain($this->domain);

            $this->refreshDomain();
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());

            return;
        } catch (CannotProcessHost $e) {
            session()->flash('error', 'Invalid domain format. Please enter a valid domain.');

            return;
        }

        try {
            $response = $domainService->issueSSL($this->domain);

            $this->refreshDomain();

            session()->flash('message', $response->message);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        } catch (CannotProcessHost $e) {
            session()->flash('error', 'Invalid domain format. Please enter a valid domain.');
        }
    }

    public function render(): View
    {
        return view('livewire.settings.domain-settings');
    }
}
