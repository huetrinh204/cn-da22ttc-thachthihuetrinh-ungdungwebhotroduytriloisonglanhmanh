// Line chart
new Chart(document.getElementById("growthChart"), {
    type: "line",
    data: {
        labels: ["T1","T2","T3","T4","T5","T6","T7","T8","T9","T10"],
        datasets: [{
            data: [1000,2000,3500,4000,5500,6500,8000,9000,10500,12000]
        }]
    }
});

// Bar chart
new Chart(document.getElementById("activityChart"), {
    type: "bar",
    data: {
        labels: ["T2","T3","T4","T5","T6","T7","CN"],
        datasets: [{
            label: "Hoàn thành",
            data: [4500,4800,5000,5600,6200,7000,6800]
        }]
    }
});

// Pie chart
new Chart(document.getElementById("pieChart"), {
    type: "pie",
    data: {
        labels: ["Sức khỏe","Tài chính","Tinh thần","Công việc","Khác"],
        datasets: [{
            data: [35,15,15,25,10]
        }]
    }
});
