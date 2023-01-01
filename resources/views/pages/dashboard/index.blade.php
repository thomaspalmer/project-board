@extends('layouts.app')

@section('content')

    <div wire:poll.60000ms>
        <livewire:dashboard.index />
    </div>

@endsection
