<script>
import { Bar } from "vue-chartjs";

export default {
  extends: Bar,
  data() {
    return {
      lables: [],
      values: [],
      colors: "",
      options: this.data,
    };
  },
  props: ["data"],
  created: function () {},
  mounted() {
    // this.labels = this.options.map((item) => item.label);
    // var arr = []; (Cách 2)
    // this.options.forEach(element => {
    //   arr.push(element.label);
    // });
    // console.log('arr1', this.labels);
    // console.log('arr2', arr);
    // this.values = this.options.map((item) => item.value);
    this.colors = this.options[0].color;
    // console.log("values", this.options);
    // for (let i = 0; i < this.options.length; i++) {
    //   this.values[i] = this.options[i].value;
    // }


    this.labels = [
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
      "December",
    ];
    this.values = [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11];


    // var values = [];
    // this.options.forEach(element => {
    //   values.push(element.value);
    // });
    // console.log("values2", this.values);
    // console.log("values",this.values);
    // console.log("colors",this.colors);

    this.renderChart(
      {
        labels: this.labels,
        datasets: [
          {
            label: "Data One",
            backgroundColor: this.colors,
            data: this.values,
          },
        ],
      },
      { responsive: true, maintainAspectRatio: false }
    );
  },
};
</script>