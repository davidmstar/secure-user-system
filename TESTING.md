# Testing Instructions

## Functional Testing
- Register a new user and confirm the account is created.
- Log in with the new account and verify the dashboard loads.
- Submit a contact message and confirm it appears in submissions.
- Edit the profile and verify the profile page updates.
- Delete a message from the submissions page.

## Security Testing
- Attempt to access dashboard.php without logging in and confirm redirection to login.php.
- Verify that form submissions require CSRF values.
- Confirm that output is escaped correctly in templates.

## Browser Testing
- Check the responsive layout on desktop and mobile widths.
- Test dark mode toggle.
