function saveAsFile() {
    fetch('/your-server-endpoint')
        .then(response => response.json())
        .then(data => {
            const blob = new Blob([JSON.stringify(data)], { type: 'text/plain' });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'data.txt';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        })
        .catch(error => console.error('Error fetching data:', error));
}

function deleteAccount() {
    // Assuming you have a server endpoint for deleting an account
    fetch('/delete-account-endpoint', {
            method: 'DELETE', // You may use another HTTP method based on your server implementation
        })
        .then(response => {
            if (response.ok) {
                sendDeleteNotification(); // Call a function to send an email notification
            } else {
                console.error('Failed to delete account');
            }
        })
        .catch(error => console.error('Error deleting account:', error));
}

function sendDeleteNotification() {
    fetch('/send-email', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                to: 'specified-email@example.com', // Replace with the specified recipient email
                subject: 'Account Deletion Notification',
                message: 'Delete my account',
            }),
        })
        .then(response => {
            if (response.ok) {
                console.log('Email notification sent successfully');
            } else {
                console.error('Failed to send email notification');
            }
        })
        .catch(error => console.error('Error sending email notification:', error));
}

const express = require('express');
const sgMail = require('@sendgrid/mail');

const app = express();
const port = 3000;

app.use(express.json());

// Set your SendGrid API key
sgMail.setApiKey('your-sendgrid-api-key');

app.post('/send-email', (req, res) => {
    const { to, subject, message } = req.body;

    const msg = {
        to,
        from: 'your-sender-email@example.com',
        subject,
        text: message,
    };

    sgMail.send(msg)
        .then(() => {
            console.log('Email sent successfully');
            res.status(200).send('Email sent successfully');
        })
        .catch(error => {
            console.error('Error sending email:', error.response.body);
            res.status(500).send('Error sending email');
        });
});

app.listen(port, () => {
    console.log(`Server is running on port ${port}`);
});