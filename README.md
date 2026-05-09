# 🏋️ Gym Management System

A comprehensive, secure, and feature-rich web application for managing gym operations, member subscriptions, and support tickets.

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [System Requirements](#system-requirements)
- [Installation & Setup](#installation--setup)
- [Project Structure](#project-structure)
- [How It Works](#how-it-works)
- [Configuration](#configuration)
- [Usage](#usage)
- [Database](#database)
- [Admin Dashboard](#admin-dashboard)
- [Security Features](#security-features)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

## 🎯 Overview

The Gym Management System is a complete solution for managing gym memberships, member accounts, support tickets, and gym entry tracking. It features a modern web interface, robust security measures including two-factor authentication, and a dedicated admin panel for staff management.

Built with PHP, MySQL, and Docker for easy deployment and scalability.

## ✨ Features

### Member Features
- **User Registration & Authentication**
  - Secure sign-up with email verification
  - Login with encrypted passwords
  - Account management and profile updates

- **Two-Factor Authentication (2FA)**
  - TOTP (Time-based One-Time Password) via authenticator apps
  - Email OTP verification
  - Enhanced account security

- **Subscription Management**
  - Multiple subscription tiers
  - Flexible duration options (monthly plans)
  - Payment method tracking
  - Subscription status monitoring

- **Health & Wellness**
  - Health status tracking
  - Medical notes storage
  - Health condition management

- **Support System**
  - Create support tickets
  - Real-time ticket messaging
  - Track ticket status (Open/Closed)
  - Communication history with admin

- **Gym Access Tracking**
  - Entry/exit logging
  - Access history
  - Membership validation

### Admin Features
- **Dashboard**
  - Overview of all users and subscriptions
  - Ticket management
  - System statistics

- **User Management**
  - View all members
  - Update user information
  - Manage subscriptions
  - Monitor login history
  - Delete accounts (with confirmation)

- **Ticket Management**
  - View all support tickets
  - Reply to tickets
  - Update ticket status
  - Communication tracking

- **Communication**
  - Send emails to members
  - Ticket messaging system
  - Admin notifications

## 💻 System Requirements

- **Server Environment**
  - PHP 8.4 or higher
  - MySQL 8.0 or higher
  - Apache web server with mod_rewrite enabled
  - Composer (PHP package manager)

- **Hardware (Recommended)**
  - 2GB RAM minimum
  - 10GB disk space
  - Multi-core processor for better performance

- **Client Requirements**
  - Modern web browser (Chrome, Firefox, Safari, Edge)
  - JavaScript enabled
  - Cookies enabled

## 🚀 Installation & Setup

### Option 1: Using Docker (Recommended)

Docker provides the easiest setup with all dependencies pre-configured.

#### Prerequisites
- [Docker](https://www.docker.com/products/docker-desktop)
- [Docker Compose](https://docs.docker.com/compose/)

#### Step-by-Step Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/ArianShafagh/GymManagment.git
   cd gym-management
   ```

2. **Configure Environment Variables**
   
   The `docker-compose.yml` file contains default configurations. Update these values as needed:
   ```yaml
   environment:
     - DB_HOST=db
     - DB_NAME=gymDB
     - DB_USER=root
     - DB_PASS=root
     - ENCRYPT_SITE_KEY=your_recaptcha_site_key
     - ENCRYPT_SECRET_KEY=your_recaptcha_secret_key
     - MailTrap_api_key=your_mailtrap_api_key
     - Admin_user=admin
     - Admin_pass=your_secure_password
     - Admin_email=admin@example.com
   ```

3. **Start Docker Services**
   ```bash
   docker-compose up -d
   ```
   
   This will start:
   - **Web Server** on `http://localhost:8000`
   - **MySQL Database** on `localhost:3306`
   - **PHPMyAdmin** on `http://localhost:8080`

4. **Verify Installation**
   - Open `http://localhost:8000` in your browser
   - You should see the Gym Management System home page
   - Database is automatically initialized with `init.sql`

5. **Stop Services**
   ```bash
   docker-compose down
   ```

### Option 2: Manual Installation (Local Development)

1. **Clone the Repository**
   ```bash
   git clone https://github.com/ArianShafagh/GymManagment.git
   cd gym-management
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Create Database**
   - Create a MySQL database named `gymDB`
   - Import the database schema:
     ```bash
     mysql -u root -p gymDB < database/init.sql
     ```

4. **Configure Application**
   - Update database credentials in `config/db.php`
   - Set reCAPTCHA keys in `config/Recaptcha_verify.php`
   - Configure Mailtrap API in `config/mailtrap.php`
   - Set 2FA settings in `config/totp.php`

5. **Set Up Web Server**
   - Configure Apache virtual host pointing to `/public` directory
   - Enable `mod_rewrite` for clean URLs

6. **Start Development**
   - Access the application through your configured domain/localhost

## 📁 Project Structure

```
gym-management/
├── public/                    # Document root (web-accessible)
│   ├── pages/                # User-facing pages
│   │   ├── Home.php
│   │   ├── Join.php         # Registration
│   │   ├── Login.php
│   │   ├── Account.php
│   │   ├── Logout.php
│   │   ├── Verify2FA.php
│   │   └── admin/           # Admin pages
│   │       ├── dashboard.php
│   │       ├── login.php
│   │       └── logout.php
│   ├── actions/             # Form processing & API endpoints
│   │   ├── create_ticket.php
│   │   ├── reply_ticket.php
│   │   ├── setup_2fa.php
│   │   ├── update_profile.php
│   │   ├── update_security.php
│   │   └── admin/          # Admin actions
│   │       ├── admin_delete_user.php
│   │       ├── admin_reply_ticket.php
│   │       ├── admin_send_email.php
│   │       ├── admin_update_ticket.php
│   │       └── admin_update_user.php
│   ├── assets/             # Images and media
│   ├── bootstrap/          # CSS/JS libraries
│   ├── css/                # Custom stylesheets
│   └── js/                 # Client-side scripts
├── config/                 # Configuration files
│   ├── db.php             # Database connection
│   ├── admin_guard.php    # Admin authentication
│   ├── Recaptcha_verify.php
│   ├── mailtrap.php       # Email service
│   └── totp.php           # 2FA configuration
├── database/
│   └── init.sql           # Database schema
├── vendor/                # Composer dependencies
├── docker-compose.yml     # Docker configuration
├── Dockerfile            # Docker image definition
├── composer.json         # PHP dependencies
└── README.md            # This file
```

## 🔄 How It Works

### User Flow

1. **Registration**
   - User fills registration form on `/pages/Join.php`
   - System validates email and creates account
   - Password is hashed using bcrypt for security
   - User can then log in

2. **Login Process**
   - User enters credentials on `/pages/Login.php`
   - Password verified against hashed version
   - Login history recorded (IP, device, timestamp)
   - Session established

3. **Two-Factor Authentication**
   - After login, if 2FA is enabled, user is redirected to `/pages/Verify2FA.php`
   - Two options:
     - **TOTP**: User enters code from authenticator app
     - **Email OTP**: Code sent to registered email (valid for 5 minutes)
   - Verification required before accessing account

4. **Account Management**
   - User can view/edit profile on `/pages/Account.php`
   - Update personal information
   - Manage subscription details
   - Enable/disable 2FA

5. **Support Tickets**
   - Create ticket from account page
   - Messages sent via `public/actions/create_ticket.php`
   - Admin responds via dashboard
   - Status tracked (Open/Closed)

6. **Gym Access**
   - Entry attempts logged with timestamp
   - Access determined by subscription validity
   - History available in account dashboard

### Admin Flow

1. **Admin Login**
   - Admin accesses `/pages/admin/login.php`
   - Protected by admin guard in `config/admin_guard.php`
   - Session validated on each request

2. **Dashboard Access**
   - View statistics and recent activity
   - Access user management, ticket system, communications
   - All actions logged for audit trail

3. **User Management**
   - View all members
   - Edit user details
   - Update subscriptions
   - View login history
   - Delete users (with confirmation)

4. **Ticket Management**
   - View all support tickets
   - Filter by status
   - Reply to customer inquiries
   - Update ticket status
   - Manage ticket history

5. **Communication**
   - Send direct emails to members
   - Reply to support tickets
   - Automated email notifications

## ⚙️ Configuration

### Database Configuration (`config/db.php`)

```php
// Update with your database credentials
$db_host = 'db';        // Docker: 'db', Local: 'localhost'
$db_user = 'root';
$db_pass = 'root';
$db_name = 'gymDB';
```

### Email Configuration (`config/mailtrap.php`)

Set your Mailtrap API key:
```php
define('MAILTRAP_API_KEY', 'your_api_key_here');
```

### reCAPTCHA Configuration (`config/Recaptcha_verify.php`)

Add your reCAPTCHA keys:
```php
define('SITE_KEY', 'your_site_key');
define('SECRET_KEY', 'your_secret_key');
```

### 2FA Configuration (`config/totp.php`)

TOTP settings for authenticator apps:
```php
// Application name shown in authenticator apps
define('APP_NAME', 'Gym Management');
```

### Admin Guard (`config/admin_guard.php`)

Handles admin session verification and authorization.

## 📖 Usage

### For Members

1. **Create Account**
   - Go to "Join" page
   - Fill in personal information
   - Choose subscription plan
   - Complete payment

2. **Access Your Account**
   - Log in with email/password
   - Complete 2FA verification
   - View subscription details
   - Track gym access history

3. **Enable Two-Factor Authentication**
   - Go to Account Settings
   - Choose 2FA method (TOTP or Email)
   - For TOTP: Scan QR code with authenticator app
   - Test verification code

4. **Get Support**
   - Create ticket from Account page
   - Describe issue
   - Receive admin responses
   - Track ticket status

### For Administrators

1. **Access Dashboard**
   - Navigate to `/pages/admin/login.php`
   - Log in with admin credentials

2. **Manage Users**
   - View member list
   - Update member information
   - Manage subscriptions
   - Monitor login activity

3. **Handle Support Tickets**
   - View incoming tickets
   - Reply to customer inquiries
   - Update ticket status
   - Close resolved tickets

4. **Send Communications**
   - Send emails to members
   - Announcements
   - Subscription renewal reminders

## 🗄️ Database

### Tables Overview

| Table | Purpose |
|-------|---------|
| `users` | Member accounts and authentication |
| `health_conditions` | Health status and medical notes |
| `login_history` | Login attempts and device tracking |
| `tickets` | Support ticket metadata |
| `ticket_messages` | Support ticket communications |
| `gym_entries` | Access logging and history |

### Schema Details

See `database/init.sql` for complete schema with all fields and relationships.

## 🔐 Security Features

- **Password Encryption**: bcrypt hashing with salt
- **Two-Factor Authentication**: TOTP and Email OTP options
- **Session Management**: Secure session handling with timeouts
- **Input Validation**: Server-side validation on all forms
- **CSRF Protection**: Token-based protection (implement if not present)
- **Admin Authentication**: Dedicated admin guard with role-based access
- **Login History**: Track and monitor access attempts
- **Secure Headers**: Implement security headers in production
- **Environment Variables**: Sensitive data in `.env` or docker-compose
- **reCAPTCHA**: Bot prevention on registration and login

### Recommended Security Best Practices

1. **Change Default Credentials**
   - Update admin password in `docker-compose.yml`
   - Use strong passwords (min 12 characters, mixed case, numbers, symbols)

2. **SSL/HTTPS**
   - Use HTTPS in production
   - Install valid SSL certificate
   - Configure Apache for HTTPS

3. **Database Security**
   - Change MySQL root password
   - Create limited-privilege user accounts
   - Regular backups

4. **Environment Security**
   - Don't commit sensitive data
   - Use `.env` files (not in version control)
   - Rotate API keys regularly

5. **Regular Updates**
   - Keep PHP updated
   - Update dependencies: `composer update`
   - Monitor security advisories

## 🐛 Troubleshooting

### Common Issues

#### Database Connection Error
```
Error: Cannot connect to database
```
**Solution:**
- Verify MySQL is running: `docker-compose ps`
- Check credentials in `config/db.php` or `docker-compose.yml`
- Ensure database is initialized
- Check network connectivity: `docker-compose logs db`

#### 2FA Not Working
```
Authenticator code not accepted
```
**Solution:**
- Verify system time is synchronized
- Check QR code was properly scanned
- Try email OTP instead
- Clear browser cookies and try again

#### Email Not Sending
```
Mailtrap emails not delivered
```
**Solution:**
- Verify Mailtrap API key in `config/mailtrap.php`
- Check Mailtrap account is active
- Review `mailtrap_debug.log` for errors
- Test with Mailtrap's test email feature

#### Admin Dashboard Not Loading
```
Unauthorized: Admin access denied
```
**Solution:**
- Verify admin session cookie is set
- Clear browser cache
- Check admin credentials
- Verify `config/admin_guard.php` is configured

#### Docker Port Already in Use
```
Error: port 8000 is already allocated
```
**Solution:**
```bash
# Change port in docker-compose.yml
ports:
  - "8001:80"  # Use 8001 instead of 8000
```

#### Permission Issues
```
Permission denied errors on file operations
```
**Solution:**
```bash
# Fix file permissions
chmod -R 755 /path/to/gym-management
chmod -R 644 /path/to/gym-management/*.*
```

### Debug Mode

Enable debug logging:
1. Check `mailtrap_debug.log` for email issues
2. Add debugging to PHP files:
   ```php
   error_log('Debug message: ' . print_r($data, true));
   ```
3. Check Docker logs: `docker-compose logs -f web`

## 🤝 Contributing

We welcome contributions! To contribute:

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

### Development Guidelines
- Follow PSR-12 coding standards
- Test thoroughly before submitting PR
- Update documentation for new features
- Add comments for complex logic

## 📝 License

This project is licensed under the MIT License - see LICENSE file for details.

## 📞 Support

For issues and questions:
- Create an issue on GitHub
- Check existing documentation
- Review troubleshooting section above

## 🎓 Learn More

- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Docker Documentation](https://docs.docker.com/)
- [Bootstrap Documentation](https://getbootstrap.com/docs/)

---

**Last Updated**: May 2026
**Version**: 1.0.0
**Author**: Arian Shafagh
