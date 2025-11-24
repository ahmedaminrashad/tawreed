# SMTP.com Email Configuration Guide

This guide will help you configure SMTP.com to send emails from your QuoTech application.

## Step 1: Get SMTP.com Credentials

1. Sign up for an account at [SMTP.com](https://www.smtp.com/)
2. Log in to your SMTP.com dashboard
3. Navigate to your account settings to retrieve:
   - SMTP Server/Host (usually `mail.smtp.com` or similar)
   - SMTP Port (587 for TLS or 465 for SSL)
   - Username (your SMTP.com username)
   - Password (your SMTP.com password)

## Step 2: Configure Environment Variables

Add the following variables to your `.env` file:

```env
MAIL_MAILER=smtp
MAIL_HOST=mail.smtp.com
MAIL_PORT=587
MAIL_USERNAME=your_smtp_username
MAIL_PASSWORD=your_smtp_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Configuration Options:

- **MAIL_HOST**: Your SMTP.com server hostname (check your SMTP.com dashboard)
- **MAIL_PORT**: 
  - `587` for TLS/STARTTLS (recommended)
  - `465` for SSL
- **MAIL_ENCRYPTION**: 
  - `tls` for port 587
  - `ssl` for port 465
- **MAIL_USERNAME**: Your SMTP.com account username
- **MAIL_PASSWORD**: Your SMTP.com account password
- **MAIL_FROM_ADDRESS**: The email address you want to send from (must be verified in SMTP.com)
- **MAIL_FROM_NAME**: The display name for your emails (e.g., "QuoTech")

## Step 3: Configure DNS Records (Important for Deliverability)

To ensure your emails are delivered properly and not marked as spam, configure SPF and DKIM records:

### SPF Record

Add a TXT record to your domain's DNS settings:

```
Type: TXT
Name: @ (or your domain)
Value: v=spf1 include:_spf.smtp.com ~all
TTL: 3600 (or default)
```

### DKIM Record

1. Contact SMTP.com support to generate a DKIM key pair
2. They will provide you with:
   - A public key
   - A selector (usually something like `smtpcom._domainkey`)
3. Add the DKIM record to your DNS:
   ```
   Type: TXT
   Name: smtpcom._domainkey (or the selector provided)
   Value: [The public key provided by SMTP.com]
   TTL: 3600 (or default)
   ```

**Note**: DNS changes can take up to 72 hours to propagate.

## Step 4: Verify Configuration

After updating your `.env` file:

1. Clear your configuration cache:
   ```bash
   php artisan config:clear
   ```

2. Test the email configuration by sending a test email or triggering the welcome email during user registration.

## Step 5: Troubleshooting

### Common Issues:

1. **Authentication Failed**
   - Double-check your `MAIL_USERNAME` and `MAIL_PASSWORD`
   - Ensure your SMTP.com account is active

2. **Connection Timeout**
   - Verify the `MAIL_HOST` is correct
   - Check if your server's firewall allows outbound connections on ports 587 or 465
   - Try switching between TLS (587) and SSL (465)

3. **Emails Going to Spam**
   - Ensure SPF and DKIM records are properly configured
   - Verify your `MAIL_FROM_ADDRESS` domain matches your SPF record domain
   - Check SMTP.com's sending reputation

4. **Port Issues**
   - Some hosting providers block port 587
   - Try port 465 with SSL encryption instead

## Additional Resources

- [SMTP.com Documentation](https://www.smtp.com/support/)
- [SMTP.com SPF and DKIM Configuration Guide](https://easydmarc.com/blog/smtp-com-spf-and-dkim-configuration/)

## Testing

You can test your email configuration by:

1. Registering a new user (will trigger welcome email)
2. Requesting a password reset (will trigger password reset email)
3. Verifying email with OTP (will trigger OTP email)

All emails should now be sent through SMTP.com!

