//récuperer les données json
$.getJSON('', function(data){
    
})

//Data Block
const data = {
    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    datasets: [{
    label: '# of Votes',
    data: [12, 19, 3, 5, 2, 3],
    borderWidth: 1,
    backgroundColor : 'yellow'
    }]
};

//Config Block

const config = {
    data : data,
    type: 'bar',
        options: {
        scales: {
        y: {
            beginAtZero: true
        }
        }
    }
};

//Render Init Blocks

const  myChart = new Chart(
    document.getElementById('myChart'),
    config
    );
