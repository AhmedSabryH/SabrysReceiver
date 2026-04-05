<x-app-layout>
    <div x-data="dashboardApp()" x-init="init()" class="space-y-8">
        <!-- Loading skeleton (shown until first data loads) -->
        <div x-show="loading" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <template x-for="i in 3">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-5 animate-pulse">
                    <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded w-3/4 mb-2"></div>
                    <div class="h-10 bg-gray-200 dark:bg-gray-700 rounded w-1/2"></div>
                </div>
            </template>
        </div>

        <!-- Stats cards with glass effect + hover scale -->
        <div x-show="!loading" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="group relative overflow-hidden bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 dark:border-gray-700">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-transparent dark:from-indigo-950/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">إجمالي الرسائل</p>
                            <p class="text-4xl font-black text-indigo-700 dark:text-indigo-400 mt-2"
                               x-text="totalMessages.toLocaleString()"></p>
                        </div>
                        <div class="text-4xl text-indigo-300 dark:text-indigo-600">📨</div>
                    </div>
                </div>
            </div>

            <div
                class="group relative overflow-hidden bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 dark:border-gray-700">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent dark:from-emerald-950/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">آخر رسالة منذ</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-200 mt-2"
                               x-text="lastMessageTime"></p>
                        </div>
                        <div class="text-4xl text-emerald-300 dark:text-emerald-600">⏱️</div>
                    </div>
                </div>
            </div>

            <div
                class="group relative overflow-hidden bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 dark:border-gray-700">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent dark:from-blue-950/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">حالة الاتصال المباشر</p>
                            <p class="text-xl font-bold mt-2"
                               :class="connected ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'"
                               x-text="connected ? '🟢 متصل' : '🔴 غير متصل'"></p>
                        </div>
                        <div class="text-4xl text-blue-300 dark:text-blue-600">⚡</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Messages table with modern design -->
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-md overflow-hidden">
            <div
                class="flex justify-between bg-gray-50/50 dark:bg-gray-900/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="font-bold text-gray-800 dark:text-gray-200">📋 الرسائل الواردة (آخر 50)</h3>
                <div class="flex items-center gap-2">

                    <!-- زرار refresh -->
                    <button
                        @click="manualRefresh"
                        :disabled="refreshing"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <!-- spinner -->
                        <svg x-show="refreshing" class="animate-spin h-4 w-4" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                            <path class="opacity-75" fill="white"
                                  d="M4 12a8 8 0 018-8v4l3-3-3-3v4a10 10 0 00-10 10h4z"></path>
                        </svg>

                        <!-- icon -->
                        <svg x-show="!refreshing" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path d="M4 4v6h6M20 20v-6h-6M5 19A9 9 0 0119 5"></path>
                        </svg>

                        <span x-text="refreshing ? 'جاري التحديث...' : 'تحديث'"></span>
                    </button>

                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-100/50 dark:bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            المرسل
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            المحتوى
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            الوقت
                        </th>
                    </tr>
                    </thead>
                    <tbody id="messages-tbody"
                           class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($recentMessages as $msg)
                        <tr class="hover:bg-indigo-50/30 dark:hover:bg-indigo-950/20 transition-colors duration-150">
                            <td class="px-6 py-4 text-sm font-mono text-gray-800 dark:text-gray-200">{{ $msg->sender ?? 'غير معروف' }}</td>
                            <td class="px-6 py-4 text-sm break-all text-gray-700 dark:text-gray-300">{{ Str::limit($msg->content, 80) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $msg->received_at->locale('ar')->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Chart & Top Senders -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div
                class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-md p-5 transition-all hover:shadow-lg">
                <h3 class="font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">📈
                    <span>آخر 7 أيام</span></h3>
                <canvas id="weeklyChart" width="400" height="200" class="w-full h-auto"></canvas>
            </div>

            <div
                class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-md p-5 transition-all hover:shadow-lg">
                <h3 class="font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">🏆 <span>أكثر المرسلين نشاطًا</span>
                </h3>
                <ul class="space-y-3">
                    @forelse($topSenders as $sender)
                        <li class="flex justify-between items-center p-2 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                            <span
                                class="font-mono text-sm text-gray-700 dark:text-gray-300">{{ $sender->sender }}</span>
                            <span
                                class="bg-indigo-100 dark:bg-indigo-900/50 text-indigo-800 dark:text-indigo-300 px-3 py-1 rounded-full text-xs font-semibold">{{ $sender->total }} رسالة</span>
                        </li>
                    @empty
                        <li class="py-4 text-center text-gray-400 dark:text-gray-500">لا توجد بيانات بعد</li>
                    @endforelse
                </ul>
            </div>
        </div>


    </div>

    <script>
        let chartInstance = null;

        function dashboardApp() {
            return {
                totalMessages: 0,
                lastMessageTime: 'لا توجد',
                connected: true,
                loading: true,
                refreshing: false,

                async init() {
                    await this.fetchData();
                    this.loading = false;
                    setInterval(() => this.fetchData(), 30000);
                },

                async manualRefresh() {
                    if (this.refreshing) return; // منع spam

                    this.refreshing = true;

                    await this.fetchData();

                    this.refreshing = false;
                },

                async fetchData() {
                    try {
                        const res = await fetch('/api/sms/fetch');
                        const json = await res.json();

                        if (json.status !== 'success') return;

                        const data = json.data;

                        this.totalMessages = data.totalMessages;
                        this.lastMessageTime = data.recentMessages.length
                            ? this.timeAgo(data.recentMessages[0].received_at)
                            : 'لا توجد';

                        this.updateChart(data.last7Days);
                        this.updateTable(data.recentMessages);

                        this.connected = true;

                    } catch (e) {
                        console.error(e);
                        this.connected = false;
                    }
                },

                updateChart(days) {
                    if (!days?.length) return;
                    const labels = days.map(d => d.label);
                    const values = days.map(d => d.count);
                    const canvas = document.getElementById('weeklyChart');
                    if (!canvas) return;

                    const ctx = canvas.getContext('2d');
                    const gradient = ctx.createLinearGradient(0, 0, 0, 200);
                    gradient.addColorStop(0, '#818cf8');
                    gradient.addColorStop(1, '#c7d2fe');

                    if (!chartInstance) {
                        chartInstance = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'عدد الرسائل',
                                    data: values,
                                    borderColor: '#4f46e5',
                                    backgroundColor: gradient,
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: '#4f46e5',
                                    pointBorderColor: '#fff',
                                    pointRadius: 4,
                                    pointHoverRadius: 6
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                plugins: {
                                    tooltip: {mode: 'index', intersect: false},
                                    legend: {position: 'top'}
                                },
                                scales: {
                                    y: {beginAtZero: true, grid: {color: '#e2e8f0'}}
                                }
                            }
                        });
                    } else {
                        chartInstance.data.labels = labels;
                        chartInstance.data.datasets[0].data = values;
                        chartInstance.update();
                    }
                },

                updateTable(messages) {
                    const tbody = document.getElementById('messages-tbody');
                    if (!tbody) return;
                    tbody.innerHTML = messages.map(msg => `
                        <tr class="hover:bg-indigo-50/30 dark:hover:bg-indigo-950/20 transition-colors duration-150">
                            <td class="px-6 py-4 text-sm font-mono text-gray-800 dark:text-gray-200">${this.escapeHtml(msg.sender || 'غير معروف')}</td>
                            <td class="px-6 py-4 text-sm break-all text-gray-700 dark:text-gray-300">${this.escapeHtml(msg.content.substring(0, 80))}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">${this.timeAgo(msg.received_at)}</td>
                        </tr>
                    `).join('');
                },

                timeAgo(dateString) {
                    const diff = Math.floor((new Date() - new Date(dateString)) / 1000);
                    if (diff < 60) return 'الآن';
                    if (diff < 3600) return Math.floor(diff / 60) + ' دقيقة';
                    if (diff < 86400) return Math.floor(diff / 3600) + ' ساعة';
                    return Math.floor(diff / 86400) + ' يوم';
                },

                escapeHtml(str) {
                    if (!str) return '';
                    return str.replace(/[&<>]/g, function (m) {
                        if (m === '&') return '&amp;';
                        if (m === '<') return '&lt;';
                        if (m === '>') return '&gt;';
                        return m;
                    });
                }
            }
        }
    </script>
</x-app-layout>
