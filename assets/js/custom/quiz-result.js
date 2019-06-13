var sets,
    arithm,
    logic,
    networks,
    numbers,
    functions,
    wrongQuestions;

sets = $('#sets-counter').val();
arithm = $('#arithm-counter').val();
logic = $('#logic-counter').val();
networks = $('#net-counter').val();
numbers = $('#num-counter').val();
functions = $('#func-counter').val();
wrongQuestions = $('#wrong-questions-counter').val();

var myPieChart = new Chart(pieChart, {
    type: 'pie',
    data: {
        datasets: [{
            data: [sets, arithm, logic, networks, numbers, functions],
            backgroundColor: ["#1d7af3", "#f3545d", "#ffa127", "#00d418", "#ef4bfd", "#744bfd"],
            borderWidth: 0
                }],
        labels: ['Set Theory', 'Arithmetic', 'Logic/Algorithms', 'Networks/Graphs', 'Numbers', 'Functions']
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            position: 'bottom',
            labels: {
                fontColor: 'rgb(65, 65, 65)',
                fontSize: 11,
                usePointStyle: true,
                padding: 20
            }
        },
        pieceLabel: {
            render: 'percentage',
            fontColor: 'white',
            fontSize: 14,
        },
        tooltips: false,
        layout: {
            padding: {
                left: 20,
                right: 20,
                top: 20,
                bottom: 20
            }
        }
    }
})

var myBarChart = new Chart(barChart, {
    type: 'bar',
    data: {
        labels: ['Set Theory', 'Arithmetic', 'Logic/Algorithms', 'Networks/Graphs', 'Numbers', 'Functions'],
        datasets: [{
            label: "Incorrect Questions Categories",
            backgroundColor: 'rgb(23, 125, 255)',
            borderColor: 'rgb(23, 125, 255)',
            data: [sets, arithm, logic, networks, numbers, functions],
                }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
                    }]
        },
    }
});
