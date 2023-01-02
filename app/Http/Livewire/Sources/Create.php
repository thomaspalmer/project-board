<?php

namespace App\Http\Livewire\Sources;

use App\Enums\Vendors;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    public string $name = '';

    public string $vendor = '';

    public bool $active = true;

    public array $credentials = [];

    /**
     * @return Redirector
     */
    public function create(): Redirector
    {
        $this->validate();

        request()->user()->sources()->create([
            'name' => $this->name,
            'vendor' => $this->vendor,
            'active' => $this->active,
            'credentials' => $this->credentials,
        ]);

        session()->flash("success", "Source has been created successfully");

        return redirect(route('sources'));
    }

    /**
     * @param string $vendor
     * @return void
     */
    public function setVendor(string $vendor): void
    {
        $this->vendor = $vendor;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'vendor' => [
                'required',
                new Enum(Vendors::class),
            ],
            'active' => [
                'nullable',
                'boolean',
            ],
            'credentials' => [
                'required',
                'array',
            ],
            'credentials.personal_access_token' => [
                'required_if:vendor,' . Vendors::GitHub->value,
                'string',
            ],
            'credentials.expires_at' => [
                'required_if:vendor,' . Vendors::GitHub->value,
                'date',
            ],
            'credentials.company_name' => [
                'required_if:vendor,' . Vendors::ActiveCollab->value,
                'string',
            ],
            'credentials.email' => [
                'required_if:vendor,' . Vendors::ActiveCollab->value,
                'email',
            ],
            'credentials.password' => [
                'required_if:vendor,' . Vendors::ActiveCollab->value,
                'string',
            ],
            'credentials.account_number' => [
                'required_if:vendor,' . Vendors::ActiveCollab->value,
                'string',
            ],
        ];
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.sources.create');
    }
}
