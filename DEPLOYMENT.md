# Maya Hospital — Hostinger par website live karna

Website ab **PHP** me hai. Header, footer aur contact details ek jagah se aate hain.
Appointment form ki requests **MySQL database** me save hoti hain, **email** par aati hain,
aur **Admin panel** (`/admin`) me dikhti hain.

---

## 1. Kaun si files upload karni hain

Hostinger → **hPanel → Websites → maya-hospital.in → File Manager → `public_html`**
me ye sab upload karein (zip banakar upload karke "Extract" karna sabse aasaan hai):

```
.htaccess          404.php          about.php        appointment.php
contact.php        gallery.php      index.php        services.php
admin/             assets/          data/            includes/
```

**Upload na karein:** `router.php` (sirf local testing ke liye), `AI_IMAGE_PROMPTS.md`,
`DEPLOYMENT.md`, `Maya_Hospital_..._English.pdf`, `mayalogo.png`, `.git`, `.claude`.

> `public_html` me Hostinger ki default `default.php` / `index.html` ho to delete kar dein.

## 2. MySQL database banana

1. hPanel → **Databases → MySQL Databases**
2. Database name, username aur ek strong password daal kar **Create** karein.
3. Ye teen cheezein note kar lein (jaise `u123456789_maya`, `u123456789_admin`, password).

Table khud ban jayegi jab pehli appointment aayegi — alag se SQL chalane ki zaroorat nahi.

## 3. Admin password ka hash banana

Apne computer ke Terminal me (apna password daal kar):

```bash
php -r "echo password_hash('YahanApnaStrongPassword', PASSWORD_DEFAULT), PHP_EOL;"
```

Jo lambi line (`$2y$10$...`) aaye, use copy kar lein. Password khud kahin likh kar save na karein
jahan doosre dekh sakein.

## 4. `config.local.php` banana (server par)

File Manager me `public_html/includes/` me jaakar `config.local.example.php` ki copy banayein,
naam rakhein **`config.local.php`**, aur values bharein:

```php
return [
    'db' => [
        'dsn'  => 'mysql:host=localhost;dbname=u123456789_maya;charset=utf8mb4',
        'user' => 'u123456789_admin',
        'pass' => 'DATABASE_KA_PASSWORD',
    ],
    'mail' => [
        'to'   => 'appointments@maya-hospital.in',   // jahan requests ka email chahiye
        'from' => 'no-reply@maya-hospital.in',
    ],
    'admin' => [
        'user'      => 'admin',
        'pass_hash' => '$2y$10$...step 3 wala hash...',
    ],
];
```

**Email:** hPanel → **Emails** me `no-reply@maya-hospital.in` (aur chahein to
`appointments@maya-hospital.in`) mailbox bana lein, taaki email spam me na jaaye.

## 5. SSL (https) on karna

hPanel → **Security → SSL** → maya-hospital.in ke liye SSL install / active karein.
`.htaccess` apne aap saare visitors ko `https://` par bhej deta hai.

## 6. Check karein

| Kya kholein | Kya hona chahiye |
|---|---|
| `https://maya-hospital.in` | Home page (splash ke saath) |
| `/about`, `/services`, `/gallery`, `/contact` | Saare pages, `.php` ke bina |
| `/about.html` | Apne aap `/about` par chala jaye |
| Contact page par form bhejein | Green "Thank you…" message + email aaye |
| `/admin` | Login → request dikhe, status badal sakein |
| `/includes/config.php` | **403 Forbidden** (secrets safe hain) |

---

## Roz ka kaam

- **Phone number / address badalna:** `includes/config.php` me `site` wale hisse me badlein —
  header, footer, buttons aur form sab jagah apne aap badal jayega.
- **Doctor ya department add karna (form ke liye):** `includes/config.php` me
  `departments` / `doctors` list me naam jodein.
- **Appointment requests:** `/admin` par login karein. Har request ka status
  *New → Confirmed → Completed / Cancelled* kar sakte hain. Phone number par click karke call ho jata hai.
- **Page ka content badalna:** `index.php`, `about.php` wagairah me seedha HTML edit karein.
  Header/footer badalna ho to `includes/header.php` / `includes/footer.php`.

## Local testing (apne computer par)

```bash
php -S localhost:8080 router.php
```

Phir browser me `http://localhost:8080` kholein. Local par database ek SQLite file
(`data/maya.sqlite`) me banta hai, MySQL ki zaroorat nahi.
