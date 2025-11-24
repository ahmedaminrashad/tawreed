# SMTP.com Connection Timeout - Quick Fix Guide

## Error Message
```
Connection could not be established with host "mail.smtp.com:587": 
stream_socket_client(): Unable to connect to mail.smtp.com:587 (Connection timed out)
```

## Quick Solutions (Try in Order)

### Solution 1: Use Port 465 with SSL (Most Common Fix)

Update your `.env` file:
```env
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
```

Then clear config cache:
```bash
php artisan config:clear
```

### Solution 2: Use Alternative Port 2525

If port 465 doesn't work, try:
```env
MAIL_PORT=2525
MAIL_ENCRYPTION=tls
```

### Solution 3: Verify SMTP.com Server Address

1. Log into your SMTP.com dashboard
2. Go to Settings → SMTP Settings
3. Find the exact SMTP server hostname
4. Update `.env`:
   ```env
   MAIL_HOST=your_actual_smtp_server.smtp.com
   ```

Common SMTP.com server addresses:
- `mail.smtp.com`
- `smtp.smtp.com`
- `mail-relay.smtp.com`
- Custom server (check your dashboard)

### Solution 4: Contact Your Hosting Provider

If you're on Laravel Forge or similar:
1. Contact support
2. Request to open outbound ports: **587**, **465**, or **2525**
3. Explain you need SMTP access for transactional emails

### Solution 5: Test Connection from Server

SSH into your server and test:
```bash
# Test port 587
telnet mail.smtp.com 587

# Test port 465
telnet mail.smtp.com 465

# Test port 2525
telnet mail.smtp.com 2525
```

If all fail, the ports are blocked by your hosting provider.

## Recommended .env Configuration

Try these configurations in order:

### Configuration 1: SSL on Port 465 (Recommended)
```env
MAIL_MAILER=smtp
MAIL_HOST=mail.smtp.com
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="QuoTech"
MAIL_TIMEOUT=30
```

### Configuration 2: TLS on Port 2525
```env
MAIL_MAILER=smtp
MAIL_HOST=mail.smtp.com
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="QuoTech"
MAIL_TIMEOUT=30
```

### Configuration 3: TLS on Port 587 (Original - if ports are opened)
```env
MAIL_MAILER=smtp
MAIL_HOST=mail.smtp.com
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="QuoTech"
MAIL_TIMEOUT=30
```

## After Making Changes

Always run:
```bash
php artisan config:clear
php artisan cache:clear
```

## Still Not Working?

1. **Check SMTP.com Account Status**
   - Ensure account is active and not suspended
   - Verify billing is up to date

2. **Check SMTP.com Dashboard**
   - Look for any IP restrictions
   - Verify your server's IP is whitelisted (if required)

3. **Alternative: Use SMTP.com API**
   - If SMTP ports are permanently blocked
   - Consider using SMTP.com's HTTP API instead
   - Contact SMTP.com support for API credentials

4. **Contact Support**
   - SMTP.com Support: https://www.smtp.com/support/
   - Your Hosting Provider Support

