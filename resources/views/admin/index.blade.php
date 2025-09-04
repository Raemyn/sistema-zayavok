<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Админка</title>
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
            leads: [],
            token: localStorage.getItem('api_token')
        }
    },
    methods: {
        loadLeads() {
            if (!this.token) {
                alert('Сначала войдите в админку');
                window.location.href = '/admin/login';
                return;
            }
            fetch('/api/leads', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + this.token
                }
            })
            .then(res => {
                if (res.status === 401) {
                    alert('Токен невалидный, войдите снова');
                    window.location.href = '/admin/login';
                    return [];
                }
                return res.json();
            })
            .then(data => {
                this.leads = data.data ?? [];
            });
        },
        updateStatus(lead) {
            fetch(`/api/leads/${lead.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + this.token
                },
                body: JSON.stringify({ status: lead.status })
            })
            .then(res => res.json())
            .then(() => alert('Статус обновлён!'))
            .catch(() => alert('Ошибка при обновлении'));
        }
    },
    mounted() {
        this.loadLeads(); // загружаем заявки сразу при открытии
    }
})
app.mount('#admin')
</script>
</body>
</html>
