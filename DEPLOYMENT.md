# Deployment Checklist

## Pre-Deployment

### 1. Environment Configuration
- [ ] Update `.env` with production database credentials
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate new `APP_KEY` for production
- [ ] Configure production URL in `APP_URL`

### 2. Third-Party Services
- [ ] Add production Razorpay credentials
- [ ] Add production Twilio credentials
- [ ] Verify Tesseract OCR is installed on server
- [ ] Test payment gateway in sandbox mode first

### 3. Database
- [ ] Create production database
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Seed property data: `php artisan db:seed --class=PropertySeeder`
- [ ] Create admin users: `php artisan db:seed --class=UserSeeder`
- [ ] Backup database

### 4. File Permissions
- [ ] Set proper permissions on `storage/` directory
- [ ] Set proper permissions on `bootstrap/cache/` directory
- [ ] Run `php artisan storage:link`

### 5. Optimization
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Run `npm run build` for production assets

### 6. Security
- [ ] Change all default passwords
- [ ] Update test user credentials
- [ ] Enable HTTPS/SSL
- [ ] Configure CORS if needed
- [ ] Set up firewall rules

### 7. Server Requirements
- [ ] PHP 8.2+ installed
- [ ] MySQL 8.0+ installed
- [ ] Composer installed
- [ ] Tesseract OCR installed
- [ ] Required PHP extensions enabled

### 8. Testing
- [ ] Test OTP login
- [ ] Test counter booking
- [ ] Test online booking
- [ ] Test payment processing
- [ ] Test PDF invoice generation
- [ ] Test WhatsApp/SMS notifications
- [ ] Test all reports

### 9. Monitoring
- [ ] Set up error logging
- [ ] Configure email notifications for errors
- [ ] Set up database backups (daily)
- [ ] Set up file backups
- [ ] Monitor server resources

### 10. Documentation
- [ ] Update organization details in invoice template
- [ ] Update contact information
- [ ] Customize property data in seeder
- [ ] Document any custom configurations

## Post-Deployment

### Immediate
- [ ] Verify all routes are accessible
- [ ] Test login functionality
- [ ] Create first real booking
- [ ] Process first real payment
- [ ] Generate first invoice

### Within 24 Hours
- [ ] Monitor error logs
- [ ] Check payment gateway transactions
- [ ] Verify notification delivery
- [ ] Test backup restoration

### Within 1 Week
- [ ] Train staff on system usage
- [ ] Collect user feedback
- [ ] Monitor performance metrics
- [ ] Optimize slow queries if any

## Rollback Plan

If deployment fails:
1. Restore previous database backup
2. Revert code to previous version
3. Clear all caches
4. Restart web server
5. Verify system is operational

## Support Contacts

- **Technical Support**: [Your contact]
- **Payment Gateway**: Razorpay support
- **SMS/WhatsApp**: Twilio support
- **Hosting Provider**: [Your hosting support]

---

**Deployment Date**: _________________

**Deployed By**: _________________

**Verified By**: _________________
