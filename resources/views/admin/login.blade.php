<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</head>
<body>
<div id="app">
    <h2>Вход в админку</h2>
    <form @submit.prevent="login">
        <input v-model="email" type="email" placeholder="Email" required><br><br>
        <input v-model="password" type="password" placeholder="Пароль" required><br><br>
        <button type="submit">Войти2</button>
    </form>
    <p style="color:red;" v-if="error">@{{ error }}</p>
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
                    // Перенаправляем в админку
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
