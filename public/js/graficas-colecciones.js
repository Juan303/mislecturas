$(document).ready(function(){
    $(".chart").each(function(){
        var id = $(this).data('id');
        var numero_comics_editados = $(this).data('numero-comics-editados');
        var numero_comics_tengo = $(this).data('comics-tengo');
        var me_faltan = numero_comics_editados - numero_comics_tengo;
        var colors = ['#76b965','#dedede'];
        /* 3 donut charts */
        var donutOptions = {
            rotation: 45,
            cutoutPercentage: 85,
            legend: {position:'bottom', padding:5, labels: {pointStyle:'circle', usePointStyle:true}}
        };
        var chDonutData2 = {
            labels: ['Tengo', 'Me faltan'],
            datasets: [
                {
                    backgroundColor: colors.slice(0,3),
                    borderWidth: 0,
                    data: [numero_comics_tengo, me_faltan]
                }
            ]
        };
        var chDonut2 = document.getElementById("chDonut_"+id);
        if (chDonut2) {
            new Chart(chDonut2, {
                type: 'doughnut',
                data: chDonutData2,
                options: donutOptions
            });
        }
    });
});
