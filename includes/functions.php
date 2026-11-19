<?php
    function rupiah(int $n): string {
        return 'Rp ' . number_format($n, 0, ',', '.');
    }

    function status_badge(string $s): string {
        $m = [
            'Diproses'   => ['warning', 'bi-hourglass-split'],
            'Selesai'    => ['success', 'bi-check-circle-fill'],
            'Dibatalkan' => ['danger', 'bi-slash-circle']
        ];
        $c = $m[$s][0] ?? 'secondary';
        $i = $m[$s][1] ?? 'bi-info-circle';
        return "<span class=\"pill pill-$c\"><i class=\"bi $i\"></i> $s</span>";
    }