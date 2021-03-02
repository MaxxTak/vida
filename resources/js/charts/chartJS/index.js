import Chart from 'chart.js';
import { COLORS } from '../../constants/colors';

export default (function () {
  // ------------------------------------------------------
  // @Line Charts
  // ------------------------------------------------------


  $.ajax({
    url: '/vida/grafico/mensal',
    type: 'GET',
    dataType: 'JSON',
    data: {},
    success: function (data) {
      console.log(data);
      // ======================================== GERAL =============================================================
      const lineChartBox = document.getElementById('line-chart');

      if (lineChartBox) {
        const lineCtx = lineChartBox.getContext('2d');
        lineChartBox.height = 80;

        new Chart(lineCtx, {
          type: 'line',
          data: {
            labels: data[3],//['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
              label                : 'Entrada (R$)',
              backgroundColor      : 'rgba(237, 231, 246, 0.5)',
              borderColor          : COLORS['deep-purple-500'],
              pointBackgroundColor : COLORS['deep-purple-700'],
              borderWidth          : 2,
              data                 : data[0],
            }, {
              label                : 'Saída (R$)',
              backgroundColor      : 'rgba(232, 245, 233, 0.5)',
              borderColor          : COLORS['blue-500'],
              pointBackgroundColor : COLORS['blue-700'],
              borderWidth          : 2,
              data                 : data[1],
            }, {
              label                : 'Balanço (R$)',
              backgroundColor      : 'rgba(232, 200, 233, 0.5)',
              borderColor          : COLORS['red-500'],
              pointBackgroundColor : COLORS['red-700'],
              borderWidth          : 2,
              data                 : data[2],//[80, 95, 100, 90, 95, 100, 90],
            }

            ],
          },

          options: {
            legend: {
              display: false,
            },
          },

        });
      }
      // =====================================================================================================================

      // ================================================== PARCELAS ================================================================
      const lineChartBoxPar = document.getElementById('line-parcela-chart');

      if (lineChartBoxPar) {
        const linePar = lineChartBoxPar.getContext('2d');
        lineChartBoxPar.height = 80;

        new Chart(linePar, {
          type: 'line',
          data: {
            labels: data[3],//['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
              label                : 'Atrasadas (R$)',
              backgroundColor      : 'rgba(237, 231, 246, 0.5)',
              borderColor          : COLORS['deep-purple-500'],
              pointBackgroundColor : COLORS['deep-purple-700'],
              borderWidth          : 2,
              data                 : data[4][0],//[80, 32, 56, 90, 67, 23, 15],
            }, {
              label                : 'Recebido (R$)',
              backgroundColor      : 'rgba(232, 245, 233, 0.5)',
              borderColor          : COLORS['blue-500'],
              pointBackgroundColor : COLORS['blue-700'],
              borderWidth          : 2,
              data                 : data[4][1],//[30, 70, 5, 50, 86, 100, 12],
            }

            ],
          },

          options: {
            legend: {
              display: false,
            },
          },

        });
      }
// ============================================================================================================================
      // ================================================== MOVIMENTAÇÕES ================================================================
      const lineChartBoxMov = document.getElementById('line-mov-chart');

      if (lineChartBoxMov) {
        const lineMov = lineChartBoxMov.getContext('2d');
        lineChartBoxMov.height = 80;

        new Chart(lineMov, {
          type: 'line',
          data: {
            labels: data[3],//['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
              label                : 'Movimentações abertas',
              backgroundColor      : 'rgba(237, 231, 246, 0.5)',
              borderColor          : COLORS['deep-purple-500'],
              pointBackgroundColor : COLORS['deep-purple-700'],
              borderWidth          : 2,
              data                 : data[5][0],//[80, 32, 56, 90, 67, 23, 15],
            }, {
              label                : 'Movimentações quitadas',
              backgroundColor      : 'rgba(232, 245, 233, 0.5)',
              borderColor          : COLORS['blue-500'],
              pointBackgroundColor : COLORS['blue-700'],
              borderWidth          : 2,
              data                 : data[5][1],//[30, 70, 5, 50, 86, 100, 12],
            }, {
              label                : 'Movimentações parcialmente quitadas',
              backgroundColor      : 'rgba(232, 200, 233, 0.5)',
              borderColor          : COLORS['red-500'],
              pointBackgroundColor : COLORS['red-700'],
              borderWidth          : 2,
              data                 : data[5][2],//[80, 95, 100, 90, 95, 100, 90],
            }

            ],
          },

          options: {
            legend: {
              display: false,
            },
          },

        });
      }
// ============================================================================================================================

    },
    error: function (data) {
      console.log(data);
    }
  });







  // ------------------------------------------------------
  // @Bar Charts
  // ------------------------------------------------------

  const barChartBox = document.getElementById('bar-chart');

  if (barChartBox) {
    const barCtx = barChartBox.getContext('2d');

    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
          label           : 'Dataset 1',
          backgroundColor : COLORS['deep-purple-500'],
          borderColor     : COLORS['deep-purple-800'],
          borderWidth     : 1,
          data            : [10, 50, 20, 40, 60, 30, 70],
        }, {
          label           : 'Dataset 2',
          backgroundColor : COLORS['light-blue-500'],
          borderColor     : COLORS['light-blue-800'],
          borderWidth     : 1,
          data            : [10, 50, 20, 40, 60, 30, 70],
        }],
      },

      options: {
        responsive: true,
        legend: {
          position: 'bottom',
        },
      },
    });
  }

  // ------------------------------------------------------
  // @Area Charts
  // ------------------------------------------------------

  const areaChartBox = document.getElementById('area-chart');

  if (areaChartBox) {
    const areaCtx = areaChartBox.getContext('2d');

    new Chart(areaCtx, {
      type: 'line',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
          backgroundColor : 'rgba(3, 169, 244, 0.5)',
          borderColor     : COLORS['light-blue-800'],
          data            : [10, 50, 20, 40, 60, 30, 70],
          label           : 'Dataset',
          fill            : 'start',
        }],
      },
    });
  }

  // ------------------------------------------------------
  // @Scatter Charts
  // ------------------------------------------------------

  const scatterChartBox = document.getElementById('scatter-chart');

  if (scatterChartBox) {
    const scatterCtx = scatterChartBox.getContext('2d');

    Chart.Scatter(scatterCtx, {
      data: {
        datasets: [{
          label           : 'My First dataset',
          borderColor     : COLORS['red-500'],
          backgroundColor : COLORS['red-500'],
          data: [
            { x: 10, y: 20 },
            { x: 30, y: 40 },
            { x: 50, y: 60 },
            { x: 70, y: 80 },
            { x: 90, y: 100 },
            { x: 110, y: 120 },
            { x: 130, y: 140 },
          ],
        }, {
          label           : 'My Second dataset',
          borderColor     : COLORS['green-500'],
          backgroundColor : COLORS['green-500'],
          data: [
            { x: 150, y: 160 },
            { x: 170, y: 180 },
            { x: 190, y: 200 },
            { x: 210, y: 220 },
            { x: 230, y: 240 },
            { x: 250, y: 260 },
            { x: 270, y: 280 },
          ],
        }],
      },
    });
  }
}())
