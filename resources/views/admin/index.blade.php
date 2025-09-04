<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Мини-админка</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</head>
<body>
<div id="admin">
    <h2>Список заявок</h2>
    <button @click="loadLeads">Загрузить заявки</button>

    <ul>
        <li v-for="lead in leads" :key="lead.id">
            {{ lead.name }} — {{ lead.status }}
            <select v-model="lead.status" @change="updateStatus(lead)">
                <option value="new">Новая</option>
                <option value="in_progress">В работе</option>
                <option value="done">Завершена</option>
                <option value="rejected">Отклонена</option>
            </select>
        </li>
    </ul>
</div>

<script>
const app = Vue.createApp({
    data() {
        return {
            leads: []
        }
    },
    methods: {
        loadLeads() {
            fetch('/api/leads', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token') // Токен сохраняй после логина
                }
            })
            .then(res => res.json())
            .then(data => {
                this.leads = data.data ?? [];
            });
        },
        updateStatus(lead) {
            fetch(`/api/leads/${lead.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
                body: JSON.stringify({ status: lead.status })
            })
            .then(res => res.json())
            .then(() => {
                alert('Статус обновлен!');
            });
        }
    }
})
app.mount('#admin')
</script>
</body>
</html>
