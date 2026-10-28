<?php
/** HTML for the database-driven sections. Markup matches the original static design. */

/** "reveal", "reveal d1", ... staggered across a row of $per items. */
function reveal(int $i, int $per = 3): string
{
    return 'reveal' . ($i % $per ? ' d' . ($i % $per) : '');
}

function chips(array $items, string $class = 'doc-chip'): string
{
    return implode('', array_map(fn ($x) => '<span class="' . $class . '">' . e($x) . '</span>', $items));
}

function render_services(): string
{
    $out = '';
    foreach (content('services') as $i => $s) {
        $out .= '<a href="' . e($s['link'] ?: '/services') . '" class="svc ' . reveal($i, 4) . '">
        <div class="svc-media"><img src="' . e(img($s['image'])) . '" alt="' . e($s['title']) . '" loading="lazy"></div>
        <div class="svc-body">
          <div class="svc-top"><span class="svc-ic">' . icon($s['icon'] ?: 'plus') . '</span><span class="svc-cat">' . e($s['category']) . '</span></div>
          <h3>' . e($s['title']) . '</h3>
          <p>' . e($s['description']) . '</p>
          <span class="svc-more">Learn more ' . icon('arrow') . '</span>
        </div>
      </a>
      ';
    }
    return $out;
}

function render_home_doctors(): string
{
    $out = '';
    foreach (content('doctors') as $i => $d) {
        $out .= '<article class="hdoc reveal d' . (($i % 2) + 1) . '">
        <div class="hdoc-photo"><img src="' . e(img($d['photo'])) . '" alt="' . e($d['name']) . '" loading="lazy"></div>
        <div class="hdoc-body">
          <span class="hdoc-dept">' . e($d['department']) . '</span>
          <h3>' . e($d['name']) . '</h3>
          <div class="doc-quals">' . chips(lines($d['quals'])) . '</div>
          <p>' . e($d['home_intro']) . '</p>
          <div class="tags">' . chips(lines($d['tags']), 'tag') . '</div>
          <div class="hdoc-actions">
            <a href="/contact#appointment" class="btn btn-red btn-sm">Book ' . icon('arrow') . '</a>
            <a href="/about#doctors" class="hdoc-link">View profile ' . icon('arrow') . '</a>
          </div>
        </div>
      </article>
    ';
    }
    return $out;
}

function render_about_doctors(): string
{
    global $site;
    $out = '';
    foreach (content('doctors') as $i => $d) {
        $school = $d['school'] !== '' && $d['school'] !== null
            ? '<span class="doc-chip doc-chip-school">' . icon('cap') . e($d['school']) . '</span>' : '';
        $list = fn ($items) => implode('', array_map(fn ($x) => '<li>' . e($x) . '</li>', $items));
        $out .= '<article class="doc-profile' . ($i % 2 ? ' rev' : '') . ' ' . reveal($i, 2) . '">
      <div class="doc-visual">
        <div class="doc-frame"><img src="' . e(img($d['photo'])) . '" alt="' . e($d['name']) . '" loading="lazy"></div>
        <ul class="doc-quick">
          <li>' . icon('steth') . '<span><small>Department</small>' . e($d['department']) . '</span></li>
          <li>' . icon('calendar') . '<span><small>Consultation</small>By appointment</span></li>
          <li>' . icon('pin') . '<span><small>Location</small>' . e($site['city']) . '</span></li>
        </ul>
      </div>
      <div class="doc-info">
        <span class="role">' . e($d['department']) . '</span>
        <h3>' . e($d['name']) . '</h3>
        <div class="doc-quals">' . chips(lines($d['quals'])) . $school . '</div>
        ' . ($d['intro'] ? '<p class="doc-lead">' . e($d['intro']) . '</p>' : '') . '
        ' . ($d['details'] ? '<p>' . e($d['details']) . '</p>' : '') . '
        <div class="doc-cols">
          <div class="doc-box"><h4>' . icon('target') . 'Areas of focus</h4><ul class="doc-list">' . $list(lines($d['focus'])) . '</ul></div>
          <div class="doc-box"><h4>' . icon('plus') . 'Treatments &amp; services</h4><ul class="doc-list">' . $list(lines($d['services'])) . '</ul></div>
        </div>
        <div class="doc-actions">
          <a href="/contact#appointment" class="btn btn-red">Book a consultation ' . icon('arrow') . '</a>
          <a href="tel:' . e(tel($site['phone_booking'])) . '" class="btn btn-ghost">' . icon('phone') . ' ' . e($site['phone_booking']) . '</a>
        </div>
      </div>
    </article>
    ';
    }
    return $out;
}

function render_faqs(): string
{
    $out = '';
    foreach (content('faqs') as $i => $f) {
        $out .= '<details class="reveal"' . ($i === 0 ? ' open' : '') . '><summary>' . e($f['question'])
            . '<span class="plus">' . icon('plus') . '</span></summary><p>' . rich($f['answer']) . '</p></details>
      ';
    }
    return $out;
}

function render_gallery_filters(): string
{
    $items  = content('gallery');
    $counts = array_count_values(array_column($items, 'category'));
    $out = '<button class="filter active" data-filter="all" aria-pressed="true">All <span class="count">' . count($items) . '</span></button>';
    foreach (GALLERY_CATEGORIES as $key => $label) {
        if (!empty($counts[$key])) {
            $out .= '
        <button class="filter" data-filter="' . $key . '" aria-pressed="false">' . e($label) . ' <span class="count">' . $counts[$key] . '</span></button>';
        }
    }
    return $out;
}

function render_gallery_items(): string
{
    $out = '';
    foreach (content('gallery') as $i => $g) {
        $cat = GALLERY_CATEGORIES[$g['category']] ?? '';
        $out .= '<figure class="g-card ' . reveal($i) . '" data-cat="' . e($g['category']) . '">
        <button class="g-media" type="button" aria-label="View larger: ' . e($g['title']) . '">
          <img src="' . e(img($g['image'])) . '" alt="' . e($g['title']) . '" loading="lazy"' . (!empty($g['top']) ? ' style="object-position:center 18%"' : '') . '>
          <span class="g-expand">' . icon('expand') . '</span>
        </button>
        <figcaption><span class="g-cat">' . e($cat) . '</span><strong>' . e($g['title']) . '</strong>' . ($g['subtitle'] ? '<span class="g-sub">' . e($g['subtitle']) . '</span>' : '') . '</figcaption>
      </figure>
      ';
    }
    return $out;
}

function gallery_count(): int
{
    return count(content('gallery'));
}
