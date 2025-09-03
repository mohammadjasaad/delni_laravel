import Chart from 'chart.js/auto';

// ✅ تنفيذ بعد تحميل الصفحة
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("canvas[data-chart]").forEach(canvas => {
        try {
            const chartData = JSON.parse(canvas.getAttribute("data-chart"));
            new Chart(canvas.getContext("2d"), chartData);
        } catch (error) {
            console.error("خطأ في رسم المخطط:", error);
        }
    });
});
