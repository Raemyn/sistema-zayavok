<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 50px;
            background-color: #f5f5f5;
        }
        #app {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        p.error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div id="app">
    <h2>Вход в админку2</h2>
    <form @submit.prevent="login">
        <label>Email:</label>
        <input v-model="email" type="email" placeholder="Email" required>

        <label>Пароль:</label>
        <input v-model="password" type="password" placeholder="Пароль" required>

        <button type="submit">Войти</button>
    </form>
    <p class="error" v-if="error">@{{ error }}</p>
</div>

<script>
const app = Vue.createApp({
    data() {
        return {
            email: '',
            password: '',
            error: ''
        }
    },
    methods: {
        login() {
            fetch('/api/auth/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    email: this.email,
                    password: this.password
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.token) {
                    // Сохраняем токен в localStorage
                    localStorage.setItem('api_token', data.token);
                    // Перенаправляем на страницу админки
                    window.location.href = '/admin/leads';
                } else {
                    this.error = data.message || 'Ошибка входа';
                }
            })
            .catch(() => {
                this.error = 'Ошибка при подключении к серверу';
            });
        }
    }
})
app.mount('#app')
</script>
</body>
</html>
