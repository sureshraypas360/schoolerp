# School ERP (Laravel) — সম্পূর্ণ গাইড

## ✅ মডিউল তালিকা (এখন সবগুলোই আছে)
- Admin/Teacher/Student/Staff — ৪ রোলের আলাদা লগইন ও ড্যাশবোর্ড
- Schools, Classes, Sections, Subjects
- Teacher/Student/Staff enrollment
- Attendance (Teacher মার্ক করে)
- Fees (Invoice + Staff Collection — ম্যানুয়াল/নগদ পেমেন্ট ট্র্যাকিং)
- Exams & Results
- Notices
- **Library** (বই, ইস্যু/রিটার্ন)
- **Hostel** (রুম, বরাদ্দ)
- **Transport** (রুট, শিক্ষার্থী assign)
- **Homework** (Teacher দেয়, Student দেখে)
- **ID Card** (প্রিন্টযোগ্য)

> **Stripe/অনলাইন কার্ড পেমেন্ট যোগ করা হয়নি** — এর জন্য আপনার নিজের Stripe অ্যাকাউন্ট ও লাইভ ডোমেইন (SSL) লাগবে। আপাতত Staff-এর ম্যানুয়াল ফি কালেকশনই ফ্রি হোস্টিংয়ে বাস্তবসম্মত সমাধান।

---

## 🚀 Deployment (SSH/artisan ছাড়া, শুধু ফাইল আপলোড + SQL ইমপোর্ট)

এই পদ্ধতিতে PC লাগবে না — শুধু ফোন/ব্রাউজার দিয়ে করা যাবে।

### ⭐ সবচেয়ে সহজ উপায়: GitHub Actions দিয়ে composer install অটোমেটিক করান
এই zip-এ একটা `.github/workflows/build.yml` ফাইল আছে যেটা GitHub-এর নিজের সার্ভারে
`composer install` চালিয়ে **vendor/ ফোল্ডারসহ, রেডি-টু-আপলোড একটা zip** বানিয়ে দেবে —
আপনাকে কোনো কমান্ড টাইপ করতে হবে না।

1. **github.com**-এ একটা নতুন (খালি) রিপোজিটরি বানান
2. রিপোতে গিয়ে **Code → Codespaces → Create codespace on main**
3. ফাইল এক্সপ্লোরারে right-click → **Upload...** → এই zip (`school-erp-laravel.zip`) আপলোড করুন
4. টার্মিনালে শুধু এই কয়েকটা লাইন চালান (ফাইল বসানো ও পুশ করার জন্য):
```bash
unzip school-erp-laravel.zip -d .
git add -A
git commit -m "School ERP source"
git push
```
5. GitHub রিপোর উপরে **Actions** ট্যাবে যান → বাম পাশে **"Build Ready-to-Deploy Package"** ক্লিক করুন → ডানপাশে **Run workflow** বাটন → **Run workflow** কনফার্ম করুন
6. ১-২ মিনিট অপেক্ষা করুন (একটা সবুজ ✓ চিহ্ন আসবে) → রান-টাতে ক্লিক করুন → নিচে **Artifacts** সেকশনে
   **school-erp-ready-to-upload** — এটাতে ক্লিক করে ডাউনলোড করুন
7. এই zip-টাই এখন সম্পূর্ণ রেডি — এতে **vendor/ ফোল্ডার, আসল APP_KEY বসানো .env, এবং SQL ফাইল সবই আছে**।
   সরাসরি ধাপ ২ (নিচে) থেকে শুরু করুন — Codespaces-এ আর কিছু বিল্ড করার দরকার নেই।

> এই zip-এর ভেতরের `.env` ফাইলে ডামি DB তথ্য থাকবে — সেটা ধাপ ২-এর পর আপনার আসল হোস্টিং DB তথ্য দিয়ে বদলে দিতে হবে।

---

### (বিকল্প) ম্যানুয়াল উপায়: নিজে Codespaces-এ বিল্ড করুন
(এটা একবারই করতে হবে — Composer ডিপেন্ডেন্সি ডাউনলোড করার জন্য, যেটা শুধু PC/ইন্টারনেট-সংযুক্ত পরিবেশেই সম্ভব)

1. GitHub-এ একটা খালি রিপো বানান
2. Code → Codespaces → Create codespace on main
3. টার্মিনালে:
```bash
composer create-project laravel/laravel temp-laravel
```
4. Explorer-এ right-click → Upload... → এই zip-টা (`school-erp-laravel.zip`) আপলোড করুন, তারপর:
```bash
unzip school-erp-laravel.zip -d src
cp -r src/school-erp/app/* temp-laravel/app/
cp -r src/school-erp/database/* temp-laravel/database/
cp -r src/school-erp/routes/* temp-laravel/routes/
cp -r src/school-erp/resources/* temp-laravel/resources/
cp src/school-erp/bootstrap/app.php temp-laravel/bootstrap/app.php
cd temp-laravel
composer install --optimize-autoloader --no-dev
php artisan key:generate --show
```
উপরের কমান্ডের আউটপুট (`base64:...`) কপি করে রাখুন — এটাই আপনার `APP_KEY`।

5. `.env` ফাইল এডিট করুন (DB তথ্য পরে বসাবেন, আপাতত ফাঁকা রাখুন বা dummy দিন):
```
APP_KEY=<উপরের base64:... মান>
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```
6. `temp-laravel` ফোল্ডারের উপর right-click → **Download** — পুরো ফোল্ডারটা zip হয়ে আপনার ফোনে ডাউনলোড হবে (vendor/ সহ, তাই বড় ফাইল হবে, ধৈর্য ধরুন)।

### ধাপ ২: হোস্টিং প্যানেলে ডাটাবেস বানান ও SQL ইমপোর্ট করুন
1. আপনার হোস্টিং কন্ট্রোল প্যানেল (cPanel/InfinityFree ইত্যাদি) থেকে **MySQL Database** বানান — host, db name, username, password নোট করুন
2. **phpMyAdmin** খুলুন → আপনার নতুন ডাটাবেস সিলেক্ট করুন → **Import** ট্যাব → `database/school_erp_full.sql` ফাইলটা (এই zip-এ আছে) আপলোড করুন → **Go**
3. এতেই সব টেবিল + ডেমো ডেটা তৈরি হয়ে যাবে — কোনো `artisan migrate` লাগবে না!
4. ডাউনলোড করা প্রজেক্টের `.env` ফাইলে DB তথ্য (host/name/user/password) হালনাগাদ করুন

### ধাপ ৩: হোস্টিং প্যানেলের File Manager দিয়ে আপলোড করুন (FTP লাগবে না)
বেশিরভাগ ফ্রি হোস্টিং-এ শুধু `htdocs` (বা `public_html`) ফোল্ডারই ওয়েব-এ দেখা যায়, এর উপরে কিছু রাখা যায় না। তাই:

1. প্রজেক্ট zip-টা (Actions থেকে পাওয়া `school-erp-ready-to-upload.zip`, অথবা ম্যানুয়াল পদ্ধতির `temp-laravel` ফোল্ডার zip করা)
2. হোস্টিং প্যানেলের **File Manager** খুলুন (ব্রাউজার-ভিত্তিক, phone থেকেই চলে)
3. `htdocs`-এ zip আপলোড করুন → **Extract** করুন (বেশিরভাগ File Manager-এ ডান-ক্লিক করলে Extract অপশন থাকে)
4. Extract হওয়া ফোল্ডারের ভেতরে `public` নামে একটা ফোল্ডার পাবেন। এখন ফোল্ডার সাজান:
   - `public/`-এর ভেতরের সব ফাইল (`index.php`, `.htaccess` ইত্যাদি) কেটে সরাসরি `htdocs/`-এ নিয়ে আসুন
   - বাকি সব (`app`, `bootstrap`, `config`, `database`, `routes`, `vendor`, `.env` ইত্যাদি, `public` বাদে) একটা ফোল্ডারে রাখুন এবং নাম দিন `laravel-app` (এটাও `htdocs/laravel-app/` হিসেবে থাকবে)
5. `htdocs/index.php` ফাইলটা File Manager-এর "Edit" দিয়ে খুলে এই দুই লাইন বদলান:
```php
require __DIR__.'/laravel-app/vendor/autoload.php';
$app = require_once __DIR__.'/laravel-app/bootstrap/app.php';
```
6. `htdocs/laravel-app/.htaccess` নামে নতুন ফাইল বানিয়ে এটা লিখুন (নিরাপত্তার জন্য, বাইরে থেকে অ্যাক্সেস বন্ধ করতে):
```apache
Deny from all
```
7. File Manager দিয়ে `htdocs/laravel-app/storage` ও `htdocs/laravel-app/bootstrap/cache` ফোল্ডারে **755** পারমিশন দিন

### ধাপ ৪: টেস্ট করুন
আপনার ডোমেইনে যান → লগইন পেজ আসবে।

লগইন (সবার পাসওয়ার্ড `password`):
- `admin@school.test`
- `teacher@school.test`
- `student@school.test`
- `staff@school.test`

---

## সমস্যা হলে
সাদা স্ক্রিন বা 500 error পেলে হোস্টিং প্যানেলে **Error Log** দেখুন (cPanel-এ "Errors" নামে থাকে), অথবা `.env`-এ সাময়িকভাবে `APP_DEBUG=true` করে পেজ রিলোড করলে আসল error দেখাবে। সেই মেসেজটা কপি করে পাঠান।
