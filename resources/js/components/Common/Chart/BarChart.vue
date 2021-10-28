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
  created: function () {
  },
  mounted() {
     this.labels = this.options.map((item) => item.label);
    // var arr = []; (Cách 2)
    // this.options.forEach(element => {
    //   arr.push(element.label);
    // });
    // console.log('arr1', this.labels);
    // console.log('arr2', arr);
    this.values = this.options.map((item) => item.value);
    this.colors = this.options[0].color;

    // console.log("lable",this.labels);
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