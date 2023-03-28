//récuperer les données json
$.getJSON("http://sae-symfony.test/recap_global", function(data){

    const median = data["score-sante-stat"].median;
    const min = data["score-sante-stat"].min;
    const max = data["score-sante-stat"].max;


    const cpt_tab = [];
    for(let i = min;i<=max;i++){
        cpt_tab.push(i);
    }

    const color_tab = [];

    cpt_tab.forEach(element => {
        color_tab.push("rgba(54, 162, 235)");
    });

    color_tab.splice(0,1);

    color_tab.splice(median-min,0,"rgba(255, 99, 132)");

    const score_value = [];

    const rawdata = data["score-sante-distribution"];

    let cpt = 0;

    rawdata.forEach(element => {
        let bool = true;
        while(bool){
            if(element["score_sante"] == cpt_tab[cpt]){
                score_value.push(element["effectif"]);
                bool = false;
            }
            else{
                score_value.push(0);
            }
            cpt++;
        }
        
    })

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