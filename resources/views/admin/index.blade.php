<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Список заявок с комментариями</title>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f0f2f5;
    padding: 50px;
}

#admin {
    max-width: 800px;
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
    margin-bottom: 15px;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}

li > div:first-child {
    margin-bottom: 10px;
}

li select {
    padding: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.comment-list {
    margin-top: 10px;
    padding-left: 20px;
    border-left: 2px solid #ddd;
}

.comment-list li {
    background-color: #eef0f3;
    margin-bottom: 5px;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 0.9em;
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
    <h2>Список заявок с комментариями</h2>
    <button @click="loadLeads">Загрузить заявки</button>

    <ul v-if="leads.length">
        <li v-for="lead in leads" :key="lead.id">
            <div>
                <strong>@{{ lead.name }}</strong><br>
                <small>@{{ lead.email }} | @{{ lead.phone }}</small><br>
                <em>@{{ lead.message }}</em>
            </div>
            <div>
                <label>Статус:</label>
                <select v-model="lead.status" @change="updateStatus(lead)">
                    <option value="new">Новая</option>
                    <option value="in_progress">В работе</option>
                    <option value="done">Завершена</option>
                    <option value="rejected">Отклонена</option>
                </select>
            </div>

            <!-- Список комментариев -->
           <ul v-if="lead.comments && lead.comments.length" class="comment-list">
    <li v-for="comment in lead.comments" :key="comment.id">
        <strong>Пользователь:</strong> @{{ comment.body }}
    </li>
</ul>
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
        async loadLeads() {
            const token = localStorage.getItem('api_token');
            if (!token) {
                this.error = 'Не авторизован';
                return;
            }

            try {
                const res = await fetch('/api/leads', {
                    headers: { 'Authorization': 'Bearer ' + token }
                });
                const data = await res.json();

                if (data && data.data) {
                    // Загружаем комментарии для каждой заявки
                    const leadsWithComments = await Promise.all(
                        data.data.map(async lead => {
                            try {
                                const commentsRes = await fetch(`/api/leads/${lead.id}/comments`, {
                                    headers: { 'Authorization': 'Bearer ' + token }
                                });
                                const commentsData = await commentsRes.json();
                                lead.comments = commentsData || [];
                            } catch {
                                lead.comments = [];
                            }
                            return lead;
                        })
                    );
                    this.leads = leadsWithComments;
                    this.error = '';
                } else {
                    this.leads = [];
                    this.error = 'Заявок не найдено';
                }
            } catch {
                this.error = 'Не удалось загрузить заявки';
            }
        },
        async updateStatus(lead) {
            const token = localStorage.getItem('api_token');
            if (!token) {
                this.error = 'Не авторизован';
                return;
            }

            try {
                const res = await fetch(`/api/leads/${lead.id}`, {
                    method: 'PUT',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status: lead.status })
                });
                const data = await res.json();

                // Если API вернул id — считаем успешным
                if (!data.id) {
                    this.error = 'Не удалось обновить статус';
                } else {
                    this.error = '';
                }
            } catch {
                this.error = 'Ошибка при обновлении статуса';
            }
        }
    }
});

app.mount('#admin');
</script>
</body>
</html>
