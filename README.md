# Dharmashala Management System

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-3-4E56A6?style=for-the-badge&logo=livewire&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind-3-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)

**A comprehensive, production-ready management system for Dharmashalas, Satrams, and religious guest houses**

[Features](#-features) • [Installation](#-installation) • [Documentation](#-documentation) • [Screenshots](#-screenshots)

</div>

---

## 📋 Overview

The Dharmashala Management System is a modern, full-featured web application designed specifically for managing religious guest houses, dharmashalas, and satrams. Built with Laravel 12 and Livewire 3, it provides a seamless experience for both staff and guests.

### Key Highlights
- 🏨 **100+ Room Management** with real-time status tracking
- 💳 **Multi-mode Payment Processing** (Cash, Online, UPI, Card)
- 📱 **Automated Notifications** via WhatsApp & SMS
- 🤖 **AI-Powered OCR** for ID verification
- 📊 **Comprehensive Analytics** with shift-wise reports
- 🧾 **Trust-Compliant PDF Invoicing**
- 🎨 **Premium UI/UX** with modern design

---

## ✨ Features

### For Staff & Administrators

#### 1. Counter Booking Interface
- Walk-in guest registration
- Multi-room selection
- ID capture with OCR auto-fill
- Instant booking creation
- Payment recording

#### 2. Visual Room Map
- Interactive 100+ room grid
- Color-coded status indicators
- Building and floor navigation
- Real-time availability updates
- Quick room details on hover

#### 3. Cash Ledger
- Daily collection tracking
- Payment mode breakdown
- Transaction history with guest details
- Date-based filtering
- Summary statistics

#### 4. Collection Reports
- Shift-wise analysis (Morning/Evening/Night)
- Date range filtering
- Bookings summary by status
- Payment analytics
- Export to PDF/Excel

#### 5. PDF Invoicing
- Trust-compliant invoice templates
- Professional formatting
- Itemized charges
- Payment history
- Download & print options

### For Guests (Public)

#### 1. Online Booking
- BookMyShow-style 4-step flow
- Live availability checking
- Room category browsing
- Automatic tariff calculation
- Instant booking confirmation

#### 2. Automated Notifications
- Booking confirmations
- Payment receipts
- Check-in reminders
- WhatsApp & SMS delivery

---

## 🚀 Installation

### Prerequisites
- PHP 8.2 or higher
- MySQL 8.0 or higher
- Composer
- Node.js & NPM
- Tesseract OCR (optional, for ID scanning)

### Quick Start

```bash
# Clone the repository
git clone <repository-url>
cd dharamshala

# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install && npm run build

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database in .env
# DB_DATABASE=dharamshala
# DB_USERNAME=root
# DB_PASSWORD=your_password

# Run migrations and seeders
php artisan migrate
php artisan db:seed --class=PropertySeeder
php artisan db:seed --class=UserSeeder

# Link storage
php artisan storage:link

# Start development server
php artisan serve
```

Visit `http://localhost:8000` and login with:
- **Mobile**: `9999999999`
- **Password**: `password123`

---

## ⚙️ Configuration

### Payment Gateway (Razorpay)

1. Sign up at [razorpay.com](https://razorpay.com)
2. Get your API Key and Secret
3. Add to `.env`:

```env
RAZORPAY_KEY=your_razorpay_key_here
RAZORPAY_SECRET=your_razorpay_secret_here
```

### Notifications (Twilio)

1. Sign up at [twilio.com](https://twilio.com)
2. Get your Account SID and Auth Token
3. Add to `.env`:

```env
TWILIO_SID=your_twilio_sid_here
TWILIO_TOKEN=your_twilio_token_here
TWILIO_PHONE_NUMBER=+1234567890
TWILIO_WHATSAPP_FROM=+1234567890
```

### OCR (Tesseract)

**Windows:**
```bash
choco install tesseract
```

**Linux:**
```bash
sudo apt install tesseract-ocr
```

Verify installation:
```bash
tesseract --version
```

---

## 🗺️ Routes

### Public Routes
- `/` - Welcome page
- `/book` - Online booking interface
- `/auth/send-otp` - Request OTP
- `/auth/verify-otp` - Verify OTP

### Authenticated Routes (Staff/Admin)
- `/rooms` - Visual room map
- `/booking/counter` - Counter booking interface
- `/ledger` - Cash ledger & payment tracking
- `/reports` - Collection reports & analytics

---

## 🛠️ Technology Stack

### Backend
- **Framework**: Laravel 12
- **Database**: MySQL 8.0
- **Authentication**: Laravel Sanctum + Custom OTP
- **Real-time**: Livewire 3
- **PDF Generation**: DomPDF
- **OCR**: Tesseract OCR
- **Payments**: Razorpay SDK
- **Notifications**: Twilio API

### Frontend
- **UI Framework**: Livewire 3
- **Styling**: Tailwind CSS 3
- **JavaScript**: Alpine.js
- **Icons**: Heroicons (SVG)
- **Fonts**: Inter (Google Fonts)

---

## 📊 Database Schema

### Core Tables
- `buildings` - Property buildings
- `floors` - Building floors
- `rooms` - Individual rooms (100+)
- `room_categories` - Room types & pricing
- `guests` - Guest information
- `bookings` - Reservations
- `booking_room` - Booking-room pivot table
- `payments` - Transaction records
- `users` - Staff/Admin users

---

## 📚 Documentation

- **[Project Summary](brain/project_summary.md)** - Comprehensive system overview
- **[Quick Start Guide](brain/quick_start.md)** - 5-minute deployment guide
- **[Walkthrough](brain/walkthrough.md)** - Feature walkthrough
- **[Task List](brain/task.md)** - Project checklist
- **[Tesseract Setup](brain/tesseract_install.md)** - OCR installation guide

---

## 🎨 Screenshots

### Counter Booking Interface
Premium UI with ID capture and OCR auto-fill

### Visual Room Map
Interactive 100+ room grid with real-time status

### Online Booking
BookMyShow-style 4-step booking flow

### Cash Ledger
Daily collection tracking with payment mode breakdown

### Collection Reports
Shift-wise analytics with export options

---

## 🔒 Security Features

- ✅ OTP-based authentication
- ✅ Role-based access control (Admin/Staff)
- ✅ Payment signature verification (Razorpay)
- ✅ CSRF protection
- ✅ Secure file uploads
- ✅ Environment-based configuration

---

## 📈 Project Metrics

- **Routes**: 15+
- **Livewire Components**: 5
- **Models**: 8
- **Services**: 4
- **Migrations**: 10+
- **Lines of Code**: ~5,000+
- **Room Capacity**: 100+ rooms
- **Payment Modes**: 4 (Cash, Online, UPI, Card)

---

## 🤝 Contributing

This is a complete, production-ready system. For customizations:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📝 License

This project is proprietary software. All rights reserved.

---

## 🙏 Acknowledgments

- Laravel Team for the amazing framework
- Livewire Team for reactive components
- Tailwind CSS for utility-first styling
- Razorpay for payment gateway
- Twilio for messaging services
- Tesseract OCR for text extraction

---

## 📞 Support

For issues, questions, or customization requests:
- 📧 Email: support@dharamshalaconnect.com
- 📱 Phone: +91 XXXXX XXXXX

---

<div align="center">

**Built with ❤️ for Dharmashalas and Satrams**

Made with Laravel • Livewire • Tailwind CSS

</div>
