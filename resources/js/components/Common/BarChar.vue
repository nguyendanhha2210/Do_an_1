<script>
import { Bar } from "vue-chartjs";

export default {
  extends: Bar,
  data() {
    return {
      lables: [],
      values: [],
      options: this.data,
    };
  },
  props: ["data"],
  created: function () {
    this.labels = this.options.map((item) => item.label);
    // var arr = []; (Cách 2)
    // this.options.forEach(element => {
    //   arr.push(element.label);
    // });
    // console.log('arr1', this.labels);
    // console.log('arr2', arr);
    this.values = this.options.map((item) => item.value);
  },
  mounted() {
    this.renderChart(
      {
        labels: this.labels,
        datasets: [
          {
            label: "Data One",
            backgroundColor: "#f87979",
            data: this.values,
          },
        ],
      },
      { responsive: true, maintainAspectRatio: false }
    );
  },
};
</script>