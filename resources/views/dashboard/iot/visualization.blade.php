@extends('dashboard.layout')
@section('title','Visualization')
@section('content')
<style>
  .verticle-bottom {
    vertical-align: bottom !important;
  }
  .verticle-middle {
    vertical-align: middle !important;
  }
</style>
<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">IOT Data Visualization</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div>
              <form id="dateFilterForm" class="row mx-2">
                <div class="col-4">
                  <div class="input-group input-group-outline mb-3 mt-1">
                    <input class="form-control" type="date" id="start_date" name="start_date">
                    <small class="d-block w-100">Start Date</small>
                  </div>
                </div>
                <div class="col-4">
                  <div class="input-group input-group-outline mb-3 mt-1">
                  <input  class="form-control" type="date" id="end_date" name="end_date">
                  <small class="d-block w-100">End Date</small>
                  </div>
                </div>

                <div class="col-4">
                  <div class="input-group input-group-outline mb-3 mt-1">
                  <button class="btn bg-gradient-info" type="submit">Apply</button>
                  </div>
                </div>
            </form>
              </div>
            <div class="row  mt-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent col-10 mx-auto mb-4">
                  <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                    <div class="chart">
                      <canvas id="chart-bars" class="chart-canvas" height="500"></canvas>
                    </div>
              </div>
          </div>
        </div>
      </div>
</div>
@endsection
@section('js')
<script>
    document.getElementById('dateFilterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        fetch('{{route('dashboard.iot-data.chart-data')}}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ start_date: startDate, end_date: endDate })
        })
        .then(response => response.json())
        .then(data => {
            createChart(data.labels, data.values);
        })
        .catch(error => console.error('Error:', error));
    });

    function createChart(labels, values) {
      var ctx = document.getElementById("chart-bars").getContext("2d");
      if (window.myChart) {
        window.myChart.destroy();
    }

    // Create new Chart.js chart
    window.myChart =  new Chart(ctx, {
        type: "bar",
        data: {
          labels: labels,
          datasets: [{
            label: "Packets",
            tension: 0.4,
            borderWidth: 0,
            borderRadius: 4,
            borderSkipped: false,
            backgroundColor: "rgba(255, 255, 255, .8)",
            data: values,
            maxBarThickness: 6
          }, ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5],
                color: 'rgba(255, 255, 255, .2)'
              },
              ticks: {
                suggestedMin: 0,
                suggestedMax: 500,
                beginAtZero: true,
                padding: 5,
                font: {
                  size: 14,
                  weight: 300,
                  family: "Roboto",
                  style: 'normal',
                  lineHeight: 2
                },
                color: "#fff"
              },
            },
            x: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5],
                color: 'rgba(255, 255, 255, .2)'
              },
              ticks: {
                display: true,
                color: '#f8f9fa',
                padding: 5,
                font: {
                  size: 14,
                  weight: 300,
                  family: "Roboto",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
          },
        },
      });
    }
  </script>
@endsection