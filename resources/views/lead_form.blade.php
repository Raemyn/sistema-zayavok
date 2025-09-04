<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Создать заявку</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</head>
<body>
<div id="app">
    <h2>Создать заявку</h2>
    <form @submit.prevent="submitLead">
        <input v-model="name" placeholder="Имя" required><br><br>
        <input v-model="email" placeholder="Email"><br><br>
        <input v-model="phone" placeholder="Телефон"><br><br>
        <textarea v-model="message" placeholder="Сообщение" required></textarea><br><br>
        <button type="submit">Отправить</button>
    </form>
</div>

<script>
const app = Vue.createApp({
    data() {
        return {
            name: '',
            email: '',
            phone: '',
            message: ''
        }
    },
    methods: {
        submitLead() {
            fetch('/api/leads', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    name: this.name,
                    email: this.email,
                    phone: this.phone,
                    message: this.message
                })
            })
            .then(res => {
                if (!res.ok) throw new Error('Ошибка');
                return res.json();
            })
            .then(() => {
                alert('Заявка отправлена!');
                this.name = '';
                this.email = '';
                this.phone = '';
                this.message = '';
            })
            .catch(() => alert('Ошибка при отправке'));
        }
    }
})
app.mount('#app')
</script>
</body>
</html>
