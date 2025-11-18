@extends('layouts.landing')

@section('content')
    <!-- Navbar -->
    <x-landing.navbar :fixed="true" />

    <!-- Hero Section -->
    <x-landing.hero-section />

    <!-- Info Section -->
    <x-landing.info-section />
@endsection
