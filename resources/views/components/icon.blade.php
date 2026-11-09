@props(['name' => 'dot', 'size' => 20, 'stroke' => 1.7])

@php
    $paths = [
        'search' => '<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>',
        'cart' => '<circle cx="9" cy="20" r="1.4"/><circle cx="18" cy="20" r="1.4"/><path d="M2.5 3h2l2.2 12.3a1.5 1.5 0 0 0 1.5 1.2h8.7a1.5 1.5 0 0 0 1.5-1.2L21 7H5.7"/>',
        'arrow-right' => '<path d="M5 12h14"/><path d="m13 6 6 6-6 6"/>',
        'arrow-up-right' => '<path d="M7 17 17 7"/><path d="M8 7h9v9"/>',
        'plus' => '<path d="M12 5v14"/><path d="M5 12h14"/>',
        'edit' => '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>',
        'trash' => '<path d="M3 6h18"/><path d="M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M10 11v6"/><path d="M14 11v6"/>',
        'check' => '<path d="M20 6 9 17l-5-5"/>',
        'check-circle' => '<path d="M22 11.1V12a10 10 0 1 1-5.9-9.1"/><path d="m22 4-10 10L9 11"/>',
        'x' => '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
        'x-circle' => '<circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/>',
        'clock' => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
        'grid' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>',
        'layout' => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/>',
        'box' => '<path d="m21 8-9-5-9 5v8l9 5 9-5Z"/><path d="M3.3 7 12 12l8.7-5"/><path d="M12 22V12"/>',
        'tag' => '<path d="M20.6 13.4 12 22 2 12V2h10l8.6 8.6a2 2 0 0 1 0 2.8Z"/><circle cx="6.5" cy="6.5" r="1.4"/>',
        'users' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.9"/><path d="M16 3.1a4 4 0 0 1 0 7.8"/>',
        'user' => '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
        'logout' => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/>',
        'whatsapp' => '<path d="M12.04 2a9.94 9.94 0 0 0-8.5 15.06L2 22l5.06-1.54A9.94 9.94 0 1 0 12.04 2Z" fill="none"/><path d="M8.5 7.2c-.2-.5-.4-.5-.6-.5h-.5c-.2 0-.5.1-.7.4-.3.3-1 .9-1 2.3s1 2.7 1.2 2.9c.1.2 2 3.1 4.9 4.3 2.4 1 2.9.8 3.5.8.5 0 1.6-.7 1.8-1.3.2-.6.2-1.2.2-1.3-.1-.1-.3-.2-.6-.3l-1.4-.7c-.2-.1-.4-.1-.5.1l-.7.9c-.1.2-.3.2-.5.1-.2-.1-1-.4-1.9-1.2-.7-.6-1.1-1.4-1.3-1.6-.1-.2 0-.3.1-.4l.3-.4c.1-.1.2-.2.2-.4 0-.1 0-.3-.1-.4Z" fill="currentColor" stroke="none"/>',
        'leaf' => '<path d="M11 20A7 7 0 0 1 4 13c0-6 8-9 16-9 0 8-3 16-9 16Z"/><path d="M4 20c2-4 5-7 9-9"/>',
        'sparkles' => '<path d="M12 3v4"/><path d="M12 17v4"/><path d="M3 12h4"/><path d="M17 12h4"/><path d="m6.3 6.3 2.5 2.5"/><path d="m15.2 15.2 2.5 2.5"/><path d="m17.7 6.3-2.5 2.5"/><path d="m8.8 15.2-2.5 2.5"/>',
        'shield' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/><path d="m9 12 2 2 4-4"/>',
        'trending' => '<path d="m3 17 6-6 4 4 8-8"/><path d="M17 7h4v4"/>',
        'handshake' => '<path d="m11 17 2 2a1 1 0 1 0 3-3"/><path d="m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.9-3.9a2 2 0 0 0-2.8 0l-.7.7a2 2 0 0 1-2.8 0l-1.9-1.9"/><path d="M3 7h3l3.6 3.6a2 2 0 0 0 2.8 0L15 7h3"/>',
        'star' => '<path d="m12 3 2.7 5.5 6 .9-4.3 4.2 1 6L12 17l-5.4 2.8 1-6L3.3 9.4l6-.9Z"/>',
        'image' => '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="1.6"/><path d="m21 15-5-5L5 21"/>',
        'upload' => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5-5 5 5"/><path d="M12 5v12"/>',
        'menu' => '<path d="M3 6h18"/><path d="M3 12h18"/><path d="M3 18h18"/>',
        'bowl' => '<path d="M3 11h18a9 9 0 0 1-18 0Z"/><path d="M9 11V7a3 3 0 0 1 6 0"/>',
        'shirt' => '<path d="M4 7 8 4h8l4 3-3 3v9H7v-9Z"/><path d="M8 4a4 4 0 0 0 8 0"/>',
        'craft' => '<path d="m12 3 2.2 4.5 5 .7-3.6 3.5.9 5L12 14.5 7.5 16.7l.9-5L4.8 8.2l5-.7Z"/>',
        'service' => '<path d="M14.7 6.3a4 4 0 0 0-5.6 5.6l-6 6a2 2 0 0 0 2.8 2.8l6-6a4 4 0 0 0 5.6-5.6l-2.5 2.5-2.8-2.8 2.5-2.5Z"/>',
        'dot' => '<circle cx="12" cy="12" r="3"/>',
        'info' => '<circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/>',
        'alert' => '<path d="m21.7 18-8-14a2 2 0 0 0-3.4 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.7-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/>',
        'camera' => '<path d="M14.5 4h-5L8 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-4Z"/><circle cx="12" cy="13" r="3.5"/>',
        'filter' => '<path d="M22 3H2l8 9.5V19l4 2v-8.5Z"/>',
        'folder' => '<path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9L10 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/>',
        'store' => '<path d="M3 9 4.5 4h15L21 9"/><path d="M3 9h18v2a3 3 0 0 1-6 0 3 3 0 0 1-6 0 3 3 0 0 1-6 0Z"/><path d="M5 13v7h14v-7"/>',
        'chevron-left' => '<path d="m15 18-6-6 6-6"/>',
        'chevron-right' => '<path d="m9 18 6-6-6-6"/>',
    ];
    $path = $paths[$name] ?? $paths['dot'];
@endphp

<svg {{ $attributes }} xmlns="http://www.w3.org/2000/svg" width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    {!! $path !!}
</svg>
