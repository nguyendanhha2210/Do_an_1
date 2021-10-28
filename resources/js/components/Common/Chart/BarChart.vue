<script>
import { Bar } from "vue-chartjs";

export default {
  extends: Bar,
  data() {
    return {
      lables: [],
      values: [],
      colors: "",
      options: [],
    };
  },
  props: ["data"],
  created: function () {},
  mounted() {
    this.options = this.data
    console.log('options', this.options)
    this.labels = this.options.map((item) => item.label);
    // var arr = []; (Cách 2)
    // this.options.forEach(element => {
    //   arr.push(element.label);
    // });
    // console.log('arr1', this.labels);
    // console.log('arr2', arr);
    // this.values = this.options.map((item) => item.value);
    this.colors = this.options[0].color;
    var arrValue = [];
    var arrLabel = [];
    console.log("values", this.options);
    this.options.forEach(element => {
      arrValue.push(element.value)
      arrLabel.push(element.label)
    });
    console.log("arrValue", arrValue);
    console.log("arrLabel", arrLabel);
    console.log("color", this.colors);

    // this.labels = [
    //   "January",
    //   "February",
    //   "March",
    //   "April",
    //   "May",
    //   "June",
    //   "July",
    //   "August",
    //   "September",
    //   "October",
    //   "November",
    //   "December",
    // ];
    // this.values = [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11];


    // var values = [];
    // this.options.forEach(element => {
    //   values.push(element.value);
    // });
    // console.log("values2", this.values);
    // console.log("values",this.values);
    // console.log("colors",this.colors);

    this.renderChart(
      {
        labels: arrLabel,
        datasets: [
          {
            label: "Data One",
            backgroundColor: this.colors,
            data: arrValue,
          },
        ],
      },
      { responsive: true, maintainAspectRatio: false }
    );
  },
};
</script>