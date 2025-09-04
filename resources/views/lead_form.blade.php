<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Создать заявку</title>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f0f2f5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    #app {
        background: white;
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        max-width: 450px;
        width: 100%;
    }
    h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #333;
    }
    form input, form textarea {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        box-sizing: border-box;
        transition: border 0.3s;
    }
    form input:focus, form textarea:focus {
        border-color: #007bff;
        outline: none;
    }
    button {
        width: 100%;
        padding: 12px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    button:hover {
        background-color: #0056b3;
    }
    @media (max-width: 500px) {
        #app {
            padding: 20px;
        }
    }
</style>
</head>
<body>
<div id="app">
    <h2>Создать заявку</h2>
    <form @submit.prevent="submitLead">
        <input v-model="name" placeholder="Имя" required>
        <input v-model="email" placeholder="Email">
        <input v-model="phone" placeholder="Телефон">
        <textarea v-model="message" placeholder="Сообщение" required rows="4"></textarea>
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
