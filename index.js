const express = require('express');
const bodyParser = require('body-parser');
const session = require('express-session');
const RedisStore = require('connect-redis').default; // 使用最新版本的 connect-redis
const { createClient } = require('redis');
const nodemailer = require('nodemailer');
const mysql = require('mysql2');
const bcrypt = require('bcrypt');
require('dotenv').config(); // 加载环境变量

const app = express();
const port = 3000;

// Redis 客戶端
const redisClient = createClient({
    socket: {
        host: process.env.REDIS_HOST || 'localhost',
        port: process.env.REDIS_PORT || 6379
    }
});

redisClient.connect().catch(console.error);

// Middlewares
app.use(bodyParser.json());
app.use(session({
    store: new RedisStore({ client: redisClient }),
    secret: process.env.SESSION_SECRET || 'your_secret_key',
    resave: false,
    saveUninitialized: false
}));

// Database connection
const connection = mysql.createConnection({
    host: process.env.DB_HOST || 'localhost',
    user: process.env.DB_USER || 'database',
    password: process.env.DB_PASSWORD || 'username',
    database: process.env.DB_NAME || 'password'
});

connection.connect((err) => {
    if (err) throw err;
    console.log('Connected to the database.');
});

// Email sending function
async function sendResetEmail(to, reset_code) {
    let transporter = nodemailer.createTransport({
        host: 'smtp-mail.outlook.com',
        port: 587,
        secure: false, // true for 465, false for 587
        auth: {
            user: process.env.EMAIL_USER || '1@1.com',
            pass: process.env.EMAIL_PASS || 'password123'
        }
    });

    let info = await transporter.sendMail({
        from: '"MyoriPass苗栗通" <1@1.com>',
        to: to,
        subject: '重置您的MyoriPass苗栗通密碼',
        text: `您的密碼重置代碼是: ${reset_code}`
    });

    console.log('Message sent: %s', info.messageId);
}

// API endpoints

// Request password reset
app.post('/forgot-password', (req, res) => {
    const email = req.body.email;

    connection.query('SELECT * FROM user WHERE email = ?', [email], (error, results) => {
        if (error) return res.status(500).send('Database error');
        
        if (results.length > 0) {
            const reset_code = Math.floor(100000 + Math.random() * 900000);
            req.session.reset_code = reset_code;
            req.session.email = email;

            sendResetEmail(email, reset_code).then(() => {
                res.send('驗證碼已發送到您的Email');
            }).catch(err => {
                console.error(err);
                res.status(500).send('發送電子郵件失敗');
            });
        } else {
            res.status(404).send('沒有找到您的Email地址');
        }
    });
});

// Reset password
app.post('/reset-password', (req, res) => {
    const input_code = req.body.reset_code;
    const new_password = req.body.new_password;

    if (req.session.reset_code && req.session.reset_code == input_code) {
        const email = req.session.email;

        bcrypt.hash(new_password, 10, (err, hashed_password) => {
            if (err) return res.status(500).send('Error hashing password');
            
            connection.query('UPDATE user SET password = ? WHERE email = ?', [hashed_password, email], (error) => {
                if (error) return res.status(500).send('Database error');

                req.session.destroy((err) => {
                    if (err) return res.status(500).send('Error destroying session');
                    res.send('您的密碼已重置完成');
                });
            });
        });
    } else {
        res.status(400).send('無效的驗證碼');
    }
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}/`);
});