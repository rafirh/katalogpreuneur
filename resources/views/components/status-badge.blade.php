@props(['status', 'lg' => false])

@php
    $map = [
        'menunggu' => ['kelas' => 'badge-menunggu', 'label' => 'Menunggu', 'icon' => 'clock'],
        'disetujui' => ['kelas' => 'badge-disetujui', 'label' => 'Disetujui', 'icon' => 'check'],
        'ditolak' => ['kelas' => 'badge-ditolak', 'label' => 'Ditolak', 'icon' => 'x'],
    ];
    $cfg = $map[$status] ?? $map['menunggu'];
@endphp

<span class="badge {{ $cfg['kelas'] }} {{ $lg ? 'badge-lg' : '' }}">
    <x-icon :name="$cfg['icon']" :size="$lg ? 14 : 12" :stroke="2.4" />
    {{ $cfg['label'] }}
</span>
