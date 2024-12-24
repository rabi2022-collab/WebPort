const express = require('express');
const nodemailer = require('nodemailer');
const bodyParser = require('body-parser');

const app = express();
const port = 3000;

// Middleware to parse form data
app.use(bodyParser.urlencoded({ extended: true }));
app.use(express.static('public')); // Serve static files like HTML

// Create a Nodemailer transporter using SMTP (example: Gmail)
const transporter = nodemailer.createTransport({
  service: 'gmail',  // Or use your SMTP service
  auth: {
    user: 'randelsilao17@gmail.com',  // Your Gmail
    pass: 'itst wssv ziov rjeb'      // Your Gmail password or app-specific password
},
});

// Handle form submission
app.post('/send', (req, res) => {
  const { name, email, message } = req.body;

  // Email options
  const mailOptions = {
    from: email, // The email from the user
    to: 'randelsilao@gmail.com', // Replace with your email or the recipient's email
    subject: `New Message from ${name}`,
    text: `You have a new message from ${name} (${email}):\n\n${message}`,
  };

  // Send email using Nodemailer
  transporter.sendMail(mailOptions, (error, info) => {
    if (error) {
      return res.status(500).send('Something went wrong.');
    }
    res.status(200).send('Message sent successfully!');
  });
});

// Start the server
app.listen(port, () => {
  console.log(`Server is running on http://localhost:${port}`);
});
