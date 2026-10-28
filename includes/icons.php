<?php
/** Inline SVG icon set used by pages and the admin icon picker. */

const ICONS = [
    'pain'     => '<path d="M12 2v4M12 18v4M4.9 4.9l2.8 2.8M16.3 16.3l2.8 2.8M2 12h4M18 12h4M4.9 19.1l2.8-2.8M16.3 7.7l2.8-2.8"/><circle cx="12" cy="12" r="3"/>',
    'spine'    => '<rect x="9" y="2" width="6" height="4" rx="1.5"/><rect x="8.5" y="7.5" width="7" height="4" rx="1.5"/><rect x="8" y="13" width="8" height="4" rx="1.5"/><rect x="7.5" y="18.5" width="9" height="3.5" rx="1.5"/>',
    'wave'     => '<path d="M2 12h3l2-6 4 12 3-9 2 3h6"/>',
    'drop'     => '<path d="M12 2.7s-6 6.4-6 11.3a6 6 0 0 0 12 0c0-4.9-6-11.3-6-11.3z"/><path d="M9.5 14.5a2.5 2.5 0 0 0 2.5 2.5"/>',
    'activity' => '<circle cx="13" cy="4" r="2"/><path d="M8 21l2-6 3 2v5M6 11l3-3 4 1 3 3 3-1M10 15l1-6"/>',
    'ivf'      => '<circle cx="12" cy="12" r="9"/><circle cx="10.5" cy="10.5" r="3.2"/><circle cx="16" cy="15" r="1"/>',
    'female'   => '<circle cx="12" cy="8" r="5"/><path d="M12 13v9M9 19h6"/>',
    'heart'    => '<path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1-1.1a5.5 5.5 0 0 0-7.8 7.8l1 1.1L12 21l7.8-7.5 1-1.1a5.5 5.5 0 0 0 0-7.8z"/>',
    'steth'    => '<path d="M6 3v6a5 5 0 0 0 10 0V3"/><path d="M11 14v2a5 5 0 0 0 10 0v-2"/><circle cx="21" cy="12" r="2"/>',
    'carm'     => '<path d="M5 4a9 9 0 0 0 0 16"/><rect x="3" y="2" width="5" height="3" rx="1"/><rect x="3" y="19" width="5" height="3" rx="1"/><path d="M13 12h8M17 8v8"/>',
    'calendar' => '<rect x="3" y="4" width="18" height="18" rx="3"/><path d="M16 2v4M8 2v4M3 10h18"/>',
    'pin'      => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/>',
    'phone'    => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/>',
    'arrow'    => '<path d="M5 12h14M13 6l6 6-6 6"/>',
    'plus'     => '<path d="M12 5v14M5 12h14"/>',
    'cap'      => '<path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c3 2 9 2 12 0v-5"/>',
    'target'   => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4"/>',
    'expand'   => '<path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/>',
];

/** Icons offered for services in the admin. */
const SERVICE_ICONS = ['pain', 'spine', 'wave', 'drop', 'activity', 'ivf', 'female', 'heart', 'steth', 'carm'];

function icon(string $name): string
{
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
        . (ICONS[$name] ?? ICONS['plus']) . '</svg>';
}
