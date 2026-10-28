<?php
/**
 * Editable Home page text and images. Values are stored in the settings table
 * as "home.<key>"; anything not saved yet uses the default below.
 *
 * Field: [type, label, default]. Types: text, textarea, lines, image.
 * Headings are split into a plain part and an "accent" part (the red italic words).
 */
const HOME_SECTIONS = [
    'Search engines (Google)' => [
        'meta_title' => ['text', 'Page title (browser tab & Google)', 'Maya Hospital | Specialized Care in Farrukhabad'],
        'meta_desc'  => ['textarea', 'Page description (Google)', 'Maya Hospital, Farrukhabad — pain management, spine & joint care, radiofrequency, PRP therapy, physiotherapy, IVF & fertility care, obstetrics and gynaecology.'],
    ],
    'Top banner (hero)' => [
        'hero_pill'      => ['text', 'Small label above heading', 'Healthcare in Farrukhabad, Uttar Pradesh'],
        'hero_line1'     => ['text', 'Heading — line 1', 'Specialized Care.'],
        'hero_line2'     => ['text', 'Heading — line 2 (red italic)', 'Personal Attention.'],
        'hero_line3'     => ['text', 'Heading — line 3', 'Better Health.'],
        'hero_lead'      => ['textarea', 'Intro paragraph', 'Welcome to Maya Hospital — find information about our specialties, medical professionals, treatment services and appointment contacts, all in one place.'],
        'hero_btn1'      => ['text', 'Main button text', 'Book an Appointment'],
        'hero_btn2'      => ['text', 'Second button text', 'Explore Our Services'],
        'hero_loc_title' => ['text', 'Location — line 1', 'Barhpur, Farrukhabad'],
        'hero_loc_sub'   => ['text', 'Location — line 2', 'Awas Vikas Tiraha'],
        'hero_image'     => ['image', 'Main photo (portrait)', 'assets/img/hero.jpg'],
    ],
    'Find the right care bar' => [
        'care_title' => ['text', 'Title', 'Find the right care'],
        'care_sub'   => ['text', 'Subtitle', 'Choose what you need help with'],
    ],
    'Scrolling strip' => [
        'marquee' => ['lines', 'Items (one per line)', "Pain Management\nSpine & Joint Care\nRadiofrequency Treatment\nC-arm Guided Procedures\nPRP Therapy\nPhysiotherapy\nIVF & Fertility Care\nObstetrics & Gynaecology"],
    ],
    'Services section' => [
        'svc_eyebrow'  => ['text', 'Small label', 'Our Key Services'],
        'svc_title'    => ['text', 'Heading', 'Care for different'],
        'svc_accent'   => ['text', 'Heading — red italic part', 'healthcare needs'],
        'svc_text'     => ['textarea', 'Paragraph', 'Pain management, spine and joint care, physiotherapy, and IVF and fertility-related healthcare — under one roof.'],
        'svc_cta_title'=> ['text', 'Help card — title', 'Not sure which service you need?'],
        'svc_cta_text' => ['textarea', 'Help card — text', 'Call the helpline and our team will guide you to the right department and doctor.'],
    ],
    'About section' => [
        'about_image'      => ['image', 'Photo', 'assets/img/reception.jpg'],
        'about_badge_num'  => ['text', 'Badge — number', '5'],
        'about_badge_text' => ['text', 'Badge — text', 'Medical specialties featured across pain, spine, physiotherapy, fertility and women\'s health.'],
        'about_eyebrow'    => ['text', 'Small label', 'About Maya Hospital'],
        'about_title'      => ['text', 'Heading', 'Healthcare close to home,'],
        'about_accent'     => ['text', 'Heading — red italic part', 'in Farrukhabad.'],
        'about_text'       => ['textarea', 'Paragraph', 'Maya Hospital is located at Awas Vikas Tiraha, Barhpur, Farrukhabad. Explore service information, learn about the doctors featured by the hospital, and contact the team to enquire about consultation and appointments.'],
        'about_points'     => ['lines', 'Tick list (one per line)', "Pain Medicine\nSpine & Joint Care\nPhysiotherapy\nIVF & Fertility\nObstetrics & Gynaecology\nAppointment support"],
    ],
    'Doctors section' => [
        'doc_eyebrow' => ['text', 'Small label', 'Meet Our Doctors'],
        'doc_title'   => ['text', 'Heading', 'Specialists who'],
        'doc_accent'  => ['text', 'Heading — red italic part', 'listen first.'],
        'doc_text'    => ['textarea', 'Paragraph', 'Meet the doctors behind Maya Hospital’s pain, spine, women’s health and fertility care — qualified specialists who take time to understand your concern before discussing options.'],
        'doc_points'  => ['lines', 'Points (one per line, up to 3)', "Specialist consultation in two departments\nConsultation by appointment\nBook by phone or the online form"],
    ],
    'Three steps section' => [
        'steps_eyebrow' => ['text', 'Small label', 'Explore Maya Hospital'],
        'steps_title'   => ['text', 'Heading', 'Your visit, in'],
        'steps_accent'  => ['text', 'Heading — red italic part', 'three simple steps'],
        'step1_title'   => ['text', 'Step 1 — title', 'Call or request online'],
        'step1_text'    => ['textarea', 'Step 1 — text', 'Use the appointment number or the Contact Us form to send your enquiry.'],
        'step2_title'   => ['text', 'Step 2 — title', 'Confirm department & doctor'],
        'step2_text'    => ['textarea', 'Step 2 — text', 'The team helps identify the right department and confirms the date and time.'],
        'step3_title'   => ['text', 'Step 3 — title', 'Visit the hospital'],
        'step3_text'    => ['textarea', 'Step 3 — text', 'Meet the specialist at Awas Vikas Tiraha, Barhpur, Farrukhabad.'],
    ],
    'FAQ section' => [
        'faq_eyebrow' => ['text', 'Small label', 'Questions & Answers'],
        'faq_title'   => ['text', 'Heading', 'Good to know'],
        'faq_accent'  => ['text', 'Heading — red italic part', 'before you visit'],
        'faq_text'    => ['textarea', 'Paragraph', 'Quick answers to common questions. For anything else, call the helpline at {phone_helpline}.'],
    ],
    'Bottom call-to-action' => [
        'cta_eyebrow' => ['text', 'Small label', 'Book a consultation'],
        'cta_title'   => ['text', 'Heading', 'Talk to our team'],
        'cta_accent'  => ['text', 'Heading — red italic part', 'today.'],
        'cta_text'    => ['textarea', 'Paragraph', 'Call the hospital to enquire about consultation availability, the right department and the doctor best suited to your needs.'],
    ],
];

function home_fields(): array
{
    return array_merge(...array_values(HOME_SECTIONS));
}

/** Saved Home page value, or its default. */
function hv(string $key): string
{
    static $saved = null;
    if ($saved === null) {
        $saved = [];
        try {
            $stmt = db()->query("SELECT k, v FROM settings WHERE k LIKE 'home.%'");
            foreach ($stmt as $r) {
                $saved[substr($r['k'], 5)] = (string) $r['v'];
            }
        } catch (Throwable $e) {
            error_log('Home content unavailable: ' . $e->getMessage());
        }
    }
    if (isset($saved[$key]) && trim($saved[$key]) !== '') {
        return $saved[$key];
    }
    return home_fields()[$key][2] ?? '';
}

/** Escaped Home page text. */
function h(string $key): string
{
    return e(hv($key));
}
