<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Список заявок</title>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f0f2f5;
    padding: 50px;
}

#admin {
    max-width: 700px;
    margin: auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

button {
    display: block;
    margin: 0 auto 20px auto;
    padding: 10px 20px;
    background-color: #007bff;
    border: none;
    color: white;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

ul {
    list-style: none;
    padding: 0;
}

li {
    background-color: #f9f9f9;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}

li select {
    padding: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

p.error {
    color: red;
    text-align: center;
    font-weight: bold;
}
</style>
</head>
<body>
<div id="admin">
    <h2>Список заявок</h2>
    <button @click="loadLeads">Загрузить заявки</button>

    <ul v-if="leads.length">
        <li v-for="lead in leads" :key="lead.id">
            <div>
                <strong>@{{ lead.name }}</strong><br>
                <small>@{{ lead.email }} | @{{ lead.phone }}</small><br>
                <em>@{{ lead.message }}</em>
            </div>
            <div>
                <select v-model="lead.status" @change="updateStatus(lead)">
                    <option value="new">Новая</option>
                    <option value="in_progress">В работе</option>
                    <option value="done">Завершена</option>
                    <option value="rejected">Отклонена</option>
                </select>
            </div>
        </li>
    </ul>

    <p v-else style="text-align:center;">Список пуст</p>
    <p class="error" v-if="error">@{{ error }}</p>
</div>

<script>
const app = Vue.createApp({
    data() {
        return {
            leads: [],
            error: ''
        }
    },
    methods: {
        loadLeads() {
            const token = localStorage.getItem('api_token');
            if (!token) {
                this.error = 'Не авторизован';
                return;
            }

            fetch('/api/leads', {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data && data.data) {
                    this.leads = data.data;
                    this.error = '';
                } else {
                    this.leads = [];
                    this.error = 'Заявок не найдено';
                }
            })
            .catch(() => {
                this.error = 'Не удалось загрузить заявки';
            });
        },
        updateStatus(lead) {
            const token = localStorage.getItem('api_token');
            if (!token) {
                this.error = 'Не авторизован';
                return;
            }

            fetch(`/api/leads/${lead.id}`, {
                method: 'PUT',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status: lead.status })
            })
            .then(res => res.json())
       .then(data => {
    // допустим, если data.id существует — значит успешно
    if (!data.id) {
        this.error = 'Не удалось обновить статус';
    } else {
        this.error = '';
    }
})
            .catch(() => {
                this.error = 'Ошибка при обновлении статуса';
            });
        }
    }
});

app.mount('#admin');
</script>
</body>
</html>
