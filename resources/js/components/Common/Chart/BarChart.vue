// <script>
// import { Bar } from "vue-chartjs";

// export default {
//   extends: Bar,
//   data() {
//     return {
//       lables: [],
//       values: [],
//       colors: "",
//       options: this.data,
//     };
//   },
//   props: ["data"],
//   created: function () {
//     this.labels = this.options.map((item) => item.label);
//     // var arr = []; (Cách 2)
//     // this.options.forEach(element => {
//     //   arr.push(element.label);
//     // });
//     // console.log('arr1', this.labels);
//     // console.log('arr2', arr);
//     this.values = this.options.map((item) => item.value);
//     this.colors = this.options[0].color;
//   },
//   mounted() {
//     this.renderChart(
//       {
//         labels: this.labels,
//         datasets: [
//           {
//             label: "Data One",
//             backgroundColor: this.colors,
//             data: this.values,
//           },
//         ],
//       },
//       { responsive: true, maintainAspectRatio: false }
//     );
//   },
// };
// </script>

<script>
import { Bar } from "vue-chartjs";

export default {
  extends: Bar,
  mounted() {
    this.renderChart(
      {
        labels: [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
          "August",
          "September",
          "October",
          "November",
          "December"
        ],
        datasets: [
          {
            label: "Data One",
            backgroundColor: "#f87979",
            data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11]
          }
        ]
      },
      { responsive: true, maintainAspectRatio: false }
    );
  }
};
</script>
