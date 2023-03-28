//récuperer les données json
$.getJSON("http://sae-symfony.test/recap_global", function(data){

    const median = data["score-sante-stats"].median;

    const cpt_tab = [];

    const score_value = data["score-sante-distribution"];

    const color_tab = [];

    let cpt = 0;

    score_value.forEach(element => {
        cpt_tab.push(cpt);
        color_tab.push("rgba(54, 162, 235)");
        cpt++;
    });

    color_tab.splice(0,1);

    color_tab.splice(median,0,"rgba(255, 99, 132)");


    const datas = {
        labels: cpt_tab,
        datasets: [{
        type: 'bar',
        label: 'Nombre de personnes',
        data: score_value,
        backgroundColor: color_tab,
        borderWidth: 1
        }
    ]
    };

    const config = {
        data : datas,
            options: {
            scales: {
            y: {
                beginAtZero: true
            }
            }
        }
    };

    const  myChart = new Chart(
        document.getElementById('chartTest'),
        config
    );

    
});