<?php

namespace App\Livewire\Concerns;

trait WithSigapAlerts
{
    protected function toastSuccess(string $message): void
    {
        $this->dispatch('sigap-toast', type: 'success', message: $message);
    }

    protected function toastError(string $message): void
    {
        $this->dispatch('sigap-toast', type: 'error', message: $message);
    }

    protected function toastInfo(string $message): void
    {
        $this->dispatch('sigap-toast', type: 'info', message: $message);
    }

    protected function toastWarning(string $message): void
    {
        $this->dispatch('sigap-toast', type: 'warning', message: $message);
    }
}
