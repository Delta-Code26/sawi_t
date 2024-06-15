document.addEventListener("DOMContentLoaded", function () {
  // Persiapkan data untuk Chart.js
  const labels = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
  ];

  // Tentukan warna untuk masing-masing tim
  const colors = [
    "#FF5733",
    "#33FF57",
    "#3357FF",
    "#F1C40F",
    "#8E44AD",
    "#2ECC71",
    "#E74C3C",
    "#3498DB",
    "#1ABC9C",
    "#9B59B6",
    "#34495E",
    "#16A085",
  ];

  const datasets = teams.map((team, index) => {
    return {
      label: team,
      data: labels.map((label, monthIndex) => {
        const found = data.find(
          (item) => item.bulan - 1 === monthIndex && item.nama_team === team
        );
        return found ? found.total_berat : 0;
      }),
      backgroundColor: colors[index % colors.length], // Menggunakan warna yang ditentukan
      borderColor: colors[index % colors.length],
      borderWidth: 1,
    };
  });

  // Buat grafik batang
  const ctx = document.getElementById("myChart").getContext("2d");
  new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels,
      datasets: datasets,
    },
    options: {
      indexAxis: "x", // Atur sumbu menjadi horizontal
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          title: {
            display: true,
            text: "Bulan",
          },
          beginAtZero: true,
          stacked: false, // Menonaktifkan penumpukan batang
        },
        y: {
          title: {
            display: true,
            text: "Total Berat (kg)",
          },
          stacked: false, // Menonaktifkan penumpukan batang
        },
      },
      plugins: {
        legend: {
          position: "right",
        },
        title: {
          display: true,
          text: "Grafik Hasil Panen Bulanan per Tim",
        },
        datalabels: {
          anchor: "end",
          align: "top",
          formatter: Math.round,
          font: {
            weight: "bold",
          },
        },
      },
      elements: {
        bar: {
          borderWidth: 2,
          barThickness: "flex", // Atur lebar batang fleksibel
          maxBarThickness: 30, // Maksimum lebar batang
        },
      },
    },
    plugins: [ChartDataLabels],
  });
});
