<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/x-icon" href="{{ asset('sigap.ico') }}">
<link rel="shortcut icon" href="{{ asset('sigap.ico') }}">

{{-- Google Fonts: Plus Jakarta Sans (Heading/Nav) & Inter (Body/Teknis) --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">

{{-- Tailwind CSS CDN dengan Design Tokens SIGAP (Civic Green) --}}
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    sigap: {
                        primary: '#1B5E3B',
                        'primary-dark': '#15452D',
                        'primary-light': '#E7F1E9',
                        secondary: '#A7C957',
                        'secondary-light': '#EDF5D8',
                        bg: '#F5F8F1',
                        surface: '#FFFFFF',
                        'surface-muted': '#F8FAF7',
                        ink: '#1F2937',
                        muted: '#6B7280',
                        subtle: '#9CA3AF',
                        border: '#E5E7EB',
                        'border-strong': '#D1D5DB',
                        success: '#16A34A',
                        warning: '#D97706',
                        danger: '#DC2626',
                        info: '#2563EB',
                    }
                },
                fontFamily: {
                    heading: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    sans: ['"Inter"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                },
                maxWidth: {
                    sigap: '1440px',
                }
            }
        }
    }
</script>

{{-- Lucide Icons & GSAP + ScrollTrigger CDN --}}
<script defer src="https://unpkg.com/lucide@latest"></script>
<script defer src="https://cdn.jsdelivr.net/npm/gsap@3/dist/gsap.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/gsap@3/dist/ScrollTrigger.min.js"></script>

<style>
    body {
        font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        background-color: #F5F8F1;
        color: #1F2937;
    }
    h1, h2, h3, h4, .font-heading {
        font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
    }
    [x-cloak] { display: none !important; }
</style>

{{-- Orkestrator Sinkronisasi UI (Lucide + GSAP Sync UI + Lifecycle Livewire) --}}
<script>
    window.SigapUI = {
        init() {
            if (window.lucide) {
                window.lucide.createIcons();
            }

            const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (window.gsap && !prefersReduced) {
                if (window.ScrollTrigger) {
                    window.gsap.registerPlugin(window.ScrollTrigger);
                    window.ScrollTrigger.getAll().forEach((trigger) => trigger.kill());
                }

                const fadeItems = document.querySelectorAll('[data-gsap="fade-up"]');
                if (fadeItems.length > 0) {
                    window.gsap.fromTo(
                        fadeItems,
                        { y: 12, opacity: 0 },
                        {
                            y: 0,
                            opacity: 1,
                            duration: 0.32,
                            stagger: 0.04,
                            ease: 'power2.out',
                            clearProps: 'transform,opacity',
                        }
                    );
                }

                const scrollSections = document.querySelectorAll('[data-gsap="reveal"]');
                scrollSections.forEach((section) => {
                    window.gsap.fromTo(
                        section,
                        { y: 16, opacity: 0 },
                        {
                            y: 0,
                            opacity: 1,
                            duration: 0.36,
                            ease: 'power2.out',
                            clearProps: 'transform,opacity',
                            scrollTrigger: window.ScrollTrigger
                                ? { trigger: section, start: 'top 90%', once: true }
                                : undefined,
                        }
                    );
                });
            }
        }
    };

    document.addEventListener('DOMContentLoaded', () => window.SigapUI.init());
    document.addEventListener('livewire:navigated', () => window.SigapUI.init());
    document.addEventListener('livewire:init', () => {
        if (window.Livewire) {
            window.Livewire.hook('morphed', () => {
                if (window.lucide) {
                    window.lucide.createIcons();
                }
            });
        }
    });
</script>
